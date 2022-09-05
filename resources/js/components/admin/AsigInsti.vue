<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <v-card-title>{{ usuario }}</v-card-title>
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
            <tr>
              <td>{{ row.item.id }}</td>
              <td>{{ row.item.inst_rif }}</td>
              <td>{{ row.item.inst_nombre }}</td>
              <td>{{ row.item.inst_telefono }}</td>
              <td>
                <v-tooltip v-if="row.item.asignar" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="asignar(row.item.id)"
                      small
                      >mdi-domain-plus</v-icon
                    >
                  </template>
                  <span>Asignar</span>
                </v-tooltip>
              </td>
            </tr>
          </template>
        </v-data-table>
        <v-card-title v-if="datosasig != ''"> Asignados </v-card-title>
        <v-col cols="12" sm="4">
          <v-textarea
            v-if="datosasig != ''"
            rows="2"
            prepend-icon="mdi-comment"
            class="mx-2"
            counter
            label="Observación"
            v-model="observ"
          ></v-textarea>
        </v-col>

        <v-card-title v-if="datosasig != ''">
          <v-text-field
            v-model="searchasig"
            append-icon="mdi-magnify"
            label="Buscar"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-data-table
          v-if="datosasig != ''"
          dense
          :headers="headers"
          :items="datosasig"
          :search="searchasig"
          item-key="name"
          class="elevation-1"
        >
          <template v-slot:item="row">
            <tr>
              <td>{{ row.item.id }}</td>
              <td>{{ row.item.inst_rif }}</td>
              <td>{{ row.item.inst_nombre }}</td>
              <td>{{ row.item.inst_telefono }}</td>
              <td>
                <v-tooltip v-if="row.item.asignar" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="eliminar(row.item.id)"
                      small
                      >mdi-domain-remove</v-icon
                    >
                  </template>
                  <span>Eliminar</span>
                </v-tooltip>
              </td>
            </tr>
          </template>
        </v-data-table>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            :disabled="datosasig.length == 0"
            color="primary"
            class="mr-4"
            @click="programar"
          >
            Asignar
          </v-btn>
        </v-card-actions>
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
  name: "asiginsti",
  props: ["id"],
  data: () => ({
    snackbar: false,
    mensaje: "",
    search: "",
    searchasig: "",
    color: "",
    usuario: "",
    datos: [],
    observ: "",
    datosasig: [],
    headers: [
      { text: "Id", value: "id" },
      { text: "Rif", value: "inst_rif" },
      { text: "Nombre", value: "inst_nombre" },
      { text: "Telef", value: "inst_telefono" },
      { text: "Acciones", value: "" },
    ],
  }),
  mounted() {
    axios
      .get(`./institu/${this.id}`)
      .then((res) => {
        //this.datos = res.data;
        this.usuario = res.data.user.name;
        this.datos = res.data.insti.map((insti) => {
          const asig = res.data.permisosuser.find(
            (el) => el.name === "asiginsti.admin.desactivar"
          );

          return {
            id: insti.id,
            inst_rif: insti.inst_rif,
            inst_nombre: insti.inst_nombre,
            inst_telefono: insti.inst_telefono,
            asignar: asig ? true : false,
          };
        });
        //para las instituciones ya asignada al usuario
        this.datosasig = res.data.instiasig.map((instasig) => {
          const asig = res.data.permisosuser.find(
            (el) => el.name === "asiginsti.admin.desactivar"
          );
          return {
            id: instasig.id,
            inst_rif: instasig.inst_rif,
            inst_nombre: instasig.inst_nombre,
            inst_telefono: instasig.inst_telefono,
            asignar: asig ? true : false,
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
    regresar() {
      setTimeout(() => this.$router.push({ name: "indexasiginsti" }), 2800);
    },
    asignar(id) {
      this.datosasig.push(this.datos.find((element) => element.id == id));
      this.datos = this.datos.filter((item) => item.id !== id);
    },
    eliminar(id) {
      var tempo = this.datosasig.find((element) => element.id == id);
      this.datos.push(this.datosasig.find((element) => element.id == id));
      this.datos.sort((a, b) => {
        return a.id - b.id;
      });
      this.datosasig = this.datosasig.filter((item) => item.id !== id);
    },
    programar() {
      const id_usu = this.id;
      const obs = this.observ;
      this.datosasig = this.datosasig.map((dat) => {
        return { ...dat, id_usu, obs };
      });
      const envio = {
        datos: this.datosasig,
        id_usu: this.id,
      };
      axios
        .post("./usuinstregist", envio)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
          this.regresar();
        })
        .catch((er) => {
          this.mensaje = er.response.data.mensaje;
          this.color = "red accent-2";
          this.snackbar = true;
        });
    },
  },
};
</script>