<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <div class="text-right">
          <v-btn v-if="create" outlined color="indigo" @click="registrar()">
            <v-icon dense>mdi-plus</v-icon>
            Registrar
          </v-btn>
        </div>
        <v-data-table
          dense
          :headers="headers"
          :items="datos"
          item-key="name"
          class="elevation-1"
        >
          <template v-slot:item="row">
            <tr>
              <td>{{ row.item.id }}</td>
              <td>{{ row.item.prog_fecha }}</td>
              <td>{{ row.item.prog_tipo_comb }}</td>
              <td>{{ row.item.prog_lts }}</td>
              <td>{{ row.item.prog_condicion }}</td>
              <td>{{ row.item.prog_inst_id }}</td>
              <td>{{ row.item.prog_inst_id_es }}</td>
              <td>
                <v-btn v-if="row.item.editar" icon @click="editar(row.item.id)">
                  <v-icon>mdi-lead-pencil</v-icon>
                </v-btn>
                <v-btn
                  v-if="row.item.eliminar"
                  icon
                  @click="eliminar(row.item.id)"
                >
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </td>
            </tr>
          </template>
        </v-data-table>
        <v-snackbar
          :timeout="2500"
          v-model="snackbar"
          absolute
          :color="color"
          rounded="pill"
          right
        >
          {{ this.mensaje }}
        </v-snackbar>
      </v-card>
      <v-dialog v-model="dialog" persistent max-width="290">
        <v-card>
          <v-card-title class="text-h5"> Eliminar programación </v-card-title>
          <v-card-text>Desea eliminar la programación?</v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="eliminarprograma()">
              Si
            </v-btn>
            <v-btn color="green darken-2" text @click="dialog = false">
              No
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </v-container>
</template>
<script>
export default {
  name: "indexprogra",
  data: () => ({
    snackbar: false,
    mensaje: "",
    id: "",
    color: "",
    dialog: false,
    datos: [],
    create: false,
    headers: [
      {
        text: "ID",
        align: "start",
        sortable: false,
        value: "id",
      },
      { text: "Fecha programación", value: "prog_fecha" },
      { text: "Tipo combustible", value: "prog_tipo_comb" },
      { text: "Litros", value: "prog_lts" },
      { text: "Condicion", value: "prog_condicion" },
      { text: "Institución", value: "prog_inst_id" },
      { text: "Estación", value: "prog_inst_id_es" },
      { text: "Acciones", value: "" },
    ],
  }),
  mounted() {
    axios
      .get("./programa")
      .then((res) => {
        //this.datos = res.data;

        this.datos = res.data.progra.map((prog) => {
          var condi = "";
          if (prog.prog_condicion == 1) condi = "Creado";
          if (prog.prog_condicion == 2) condi = "Programado";
          if (prog.prog_condicion == 3) condi = "Aprobado";
          if (prog.prog_condicion == 4) condi = "Negado";

          var tipocom = "";
          if (prog.prog_tipo_comb == 1) tipocom = "Gasolina";
          if (prog.prog_tipo_comb == 2) tipocom = "Gasoil";

          const edit = res.data.permisosuser.find(
            (el) => el.name === "admin.user.edit"
          );
          const eliminar = res.data.permisosuser.find(
            (el) => el.name === "admin.user.destroy"
          );
          const crear = res.data.permisosuser.find(
            (el) => el.name === "admin.user.create"
          );
          if (crear) this.create = true;
          return {
            id: prog.id,
            prog_fecha: prog.prog_fecha.slice(0, 10),
            prog_tipo_comb: tipocom,
            prog_lts: prog.prog_lts,
            prog_condicion: condi,
            prog_inst_id: prog.institu,
            prog_inst_id_es: prog.estacion,
            editar: edit ? true : false,
            eliminar: eliminar ? true : false,
          };
        });
        //window.location.reload();
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = er;
        this.snackbar = true;
      });
  },
  methods: {
    editar(id) {
      this.$router.push({ name: "programaedit", params: { id: id } });
    },
    eliminar(id) {
      this.id = id;
      this.dialog = true;
    },
    eliminarprograma() {
      axios
        .delete(`./programa/${this.id}`)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
          this.dialog = false;
          this.cargar();
        })
        .catch((er) => {
          this.color = "red accent-2";
          this.mensaje = er;
          this.snackbar = true;
        });
    },
    registrar() {
      this.$router.push({ name: "programar" });
    },
    cargar() {
      axios
        .get("./programa")
        .then((res) => {
          //this.datos = res.data;
          this.datos = res.data.progra.map((prog) => {
            const edit = res.data.permisosuser.find(
              (el) => el.name === "admin.user.edit"
            );
            const eliminar = res.data.permisosuser.find(
              (el) => el.name === "admin.user.destroy"
            );
            const crear = res.data.permisosuser.find(
              (el) => el.name === "admin.user.create"
            );
            if (crear) this.create = true;
            return {
              id: prog.id,
              prog_fecha: prog.prog_fecha.slice(0, 10),
              prog_tipo_comb: prog.prog_tipo_comb,
              prog_lts: prog.prog_lts,
              prog_condicion: prog.prog_condicion,
              prog_inst_id: prog.institu,
              prog_inst_id_es: prog.estacion,
              editar: edit ? true : false,
              eliminar: eliminar ? true : false,
            };
          });
          //window.location.reload();
        })
        .catch((er) => {
          this.color = "red accent-2";
          this.mensaje = er;
          this.snackbar = true;
        });
    },
  },
};
</script>