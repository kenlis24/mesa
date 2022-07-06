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
            <tr class="text-xs-body-2">
              <td>{{ row.item.id }}</td>
              <td>{{ row.item.inst_rif }}</td>
              <td>{{ row.item.inst_nombre }}</td>
              <td>{{ row.item.inst_tipo }}</td>
              <td>{{ row.item.inst_telefono }}</td>
              <td>{{ row.item.inst_dependencia }}</td>
              <td>{{ row.item.inst_sector }}</td>
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
                      @click="desactivar(row.item.id, row.item.inst_estado)"
                      small
                      :color="row.item.inst_estado == 'A' ? 'blue' : 'red'"
                      >mdi-cancel</v-icon
                    >
                  </template>
                  <span
                    v-text="
                      row.item.inst_estado == 'A' ? 'Desactivar' : 'Activar'
                    "
                  ></span>
                </v-tooltip>
                <v-tooltip v-if="row.item.eliminar" top>
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
          <v-card-title class="text-h5"> Eliminar institución </v-card-title>
          <v-card-text
            >Desea eliminar la institución? borrará las programaciones
            dependientes</v-card-text
          >
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="eliminarinstitu()">
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
  name: "indexinsti",
  data: () => ({
    snackbar: false,
    show: false,
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
      { text: "Rif", value: "inst_rif" },
      { text: "Nombre", value: "inst_nombre" },
      { text: "Tipo", value: "inst_tipo" },
      { text: "Teléfono", value: "inst_telefono" },
      { text: "Dependencia", value: "inst_dependencia" },
      { text: "Sector", value: "inst_sector" },
      { text: "Acciones", value: "" },
    ],
  }),
  mounted() {
    axios
      .get("./institu")
      .then((res) => {
        //this.datos = res.data;

        this.datos = res.data.institodas.map((insti) => {
          var condi = "";
          if (insti.inst_dependencia == 1) condi = "Nacional";
          if (insti.inst_dependencia == 2) condi = "Regional";
          if (insti.inst_dependencia == 3) condi = "Estadal";
          if (insti.inst_dependencia == 4) condi = "Municipal";

          var tipoinst = "";
          if (insti.inst_tipo == 1) tipoinst = "Organismo";
          if (insti.inst_tipo == 2) tipoinst = "Estación de Servicio";

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
            id: insti.id,
            inst_rif: insti.inst_rif,
            inst_nombre: insti.inst_nombre,
            inst_tipo: tipoinst,
            inst_telefono: insti.inst_telefono,
            inst_dependencia: insti.inst_dependencia,
            inst_sector: insti.inst_sector,
            inst_estado: insti.inst_estado,
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
      this.$router.push({ name: "instiedit", params: { id: id } });
    },
    eliminar(id) {
      this.id = id;
      this.dialog = true;
    },
    desactivar(id, acti) {
      var actualiza = {
        prog_fecha: "hhh",
      };
      axios
        .put(`./institu/${id}/${acti}`)
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
    eliminarinstitu() {
      axios
        .delete(`./institu/${this.id}`)
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
      this.$router.push({ name: "institucion" });
    },
    cargar() {
      axios
        .get("./institu")
        .then((res) => {
          //this.datos = res.data;
          this.datos = res.data.institodas.map((insti) => {
            var condi = "";
            if (insti.inst_dependencia == 1) condi = "Nacional";
            if (insti.inst_dependencia == 2) condi = "Regional";
            if (insti.inst_dependencia == 3) condi = "Estadal";
            if (insti.inst_dependencia == 4) condi = "Municipal";

            var tipoinst = "";
            if (insti.inst_tipo == 1) tipoinst = "Organismo";
            if (insti.inst_tipo == 2) tipoinst = "Estación de Servicio";

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
              id: insti.id,
              inst_rif: insti.inst_rif,
              inst_nombre: insti.inst_nombre,
              inst_tipo: tipoinst,
              inst_telefono: insti.inst_telefono,
              inst_dependencia: insti.inst_dependencia,
              inst_sector: insti.inst_sector,
              inst_estado: insti.inst_estado,
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