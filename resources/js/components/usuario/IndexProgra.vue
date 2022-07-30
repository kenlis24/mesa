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
              <td>{{ row.item.prog_tipo_comb }}</td>
              <td>{{ row.item.prog_tipo_vehi }}</td>
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
                      @click="
                        row.item.prog_condicion != 'Aprobado'
                          ? editar(row.item.id)
                          : editar(row.item.id)
                      "
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
                      @click="desactivar(row.item.id, row.item.prog_estado)"
                      small
                      :color="row.item.prog_estado == 'A' ? 'blue' : 'red'"
                      >mdi-cancel</v-icon
                    >
                  </template>
                  <span
                    v-text="
                      row.item.prog_estado == 'A' ? 'Desactivar' : 'Activar'
                    "
                  ></span>
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
      { text: "Tipo vehículo", value: "prog_tipo_vehi" },
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

          var tipocom = "";
          if (prog.prog_tipo_comb == 1) tipocom = "Gasolina";
          if (prog.prog_tipo_comb == 2) tipocom = "Gasoil";

          var tipovehi = "";
          if (prog.prog_tipo_vehi == 1) tipovehi = "Automóvil";
          if (prog.prog_tipo_vehi == 2) tipovehi = "Motocicleta";

          const edit = res.data.permisosuser.find(
            (el) => el.name === "admin.user.edit"
          );
          const crear = res.data.permisosuser.find(
            (el) => el.name === "admin.user.create"
          );
          if (crear) this.create = true;
          return {
            id: prog.id,
            prog_fecha: prog.prog_fecha.slice(0, 10),
            prog_tipo_comb: tipocom,
            prog_tipo_vehi: tipovehi,
            prog_lts: prog.prog_lts,
            prog_condicion: condi,
            prog_inst_id: prog.institu,
            prog_inst_id_es: prog.estacion,
            prog_estado: prog.prog_estado,
            inst_estado: prog.inst_estado,
            esta_estado: prog.esta_estado,
            editar: edit ? true : false,
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
    desactivar(id, acti) {
      axios
        .put(`./programa/${id}/${acti}`)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
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

            var tipocom = "";
            if (prog.prog_tipo_comb == 1) tipocom = "Gasolina";
            if (prog.prog_tipo_comb == 2) tipocom = "Gasoil";

            var tipovehi = "";
            if (prog.prog_tipo_vehi == 1) tipovehi = "Automóvil";
            if (prog.prog_tipo_vehi == 2) tipovehi = "Motocicleta";

            const edit = res.data.permisosuser.find(
              (el) => el.name === "admin.user.edit"
            );
            const crear = res.data.permisosuser.find(
              (el) => el.name === "admin.user.create"
            );
            if (crear) this.create = true;
            return {
              id: prog.id,
              prog_fecha: prog.prog_fecha.slice(0, 10),
              prog_tipo_comb: tipocom,
              prog_tipo_vehi: tipovehi,
              prog_lts: prog.prog_lts,
              prog_condicion: condi,
              prog_inst_id: prog.institu,
              prog_inst_id_es: prog.estacion,
              prog_estado: prog.prog_estado,
              inst_estado: prog.inst_estado,
              esta_estado: prog.esta_estado,
              editar: edit ? true : false,
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