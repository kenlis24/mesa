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
        <v-card-title>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Buscar"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-data-table
          dense
          :headers="headers"
          :items="datos"
          :search="search"
          item-key="name"
          class="elevation-1"
        >
          <template v-slot:item="row">
            <tr
              :class="activo(row.item)"
              :title="
                activo(row.item) != ''
                  ? 'La Institución o Estacion esta inactiva'
                  : ''
              "
            >
              <td>{{ row.item.id }}</td>
              <td>{{ row.item.prog_fecha }}</td>
              <td>{{ row.item.prog_lts }}</td>
              <td>{{ row.item.prog_condicion }}</td>
              <td>{{ row.item.prog_inst_id }}</td>
              <td>{{ row.item.prog_inst_id_es }}</td>
              <td>
                <v-tooltip v-if="row.item.editar" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="editar(row.item.id)"
                      small
                      >mdi-lead-pencil</v-icon
                    >
                  </template>
                  <span>Editar</span>
                </v-tooltip>
                <v-tooltip v-if="row.item.editar" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="eliminar(row.item.id)"
                      small
                      >mdi-delete</v-icon
                    >
                  </template>
                  <span>Eliminar</span>
                </v-tooltip>
              </td>
            </tr>
          </template>
        </v-data-table>
        <v-snackbar
          bottom
          :timeout="2500"
          v-model="snackbar"
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
    search: "",
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
            prog_lts: prog.prog_lts,
            prog_condicion: condi,
            prog_inst_id: prog.institu,
            prog_inst_id_es: prog.estacion,
            inst_estado: prog.inst_estado,
            esta_estado: prog.esta_estado,
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
    activo(valor) {
      if (valor.inst_estado == "A" && valor.esta_estado == "A") {
        return "";
      } else return "warning";
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
            var condi = "";
            if (prog.prog_condicion == 1) condi = "Creado";
            if (prog.prog_condicion == 2) condi = "Programado";
            if (prog.prog_condicion == 3) condi = "Aprobado";
            if (prog.prog_condicion == 4) condi = "Negado";

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
  },
};
</script>