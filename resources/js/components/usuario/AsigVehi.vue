<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <v-card-title>
          {{ cedula + " - " + nombres + " " + apellidos }}
        </v-card-title>
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
              <td>{{ row.item.vehi_placa }}</td>
              <td>{{ row.item.vehi_tag }}</td>
              <td>{{ row.item.vehi_tipo_vehi }}</td>
              <td>{{ row.item.mca_nombre }}</td>
              <td>{{ row.item.mod_nombre }}</td>
              <td>
                <v-tooltip v-if="row.item.asignar" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="asignar(row.item.id)"
                      small
                      >mdi-car</v-icon
                    >
                  </template>
                  <span>Asignar</span>
                </v-tooltip>
              </td>
            </tr>
          </template>
        </v-data-table>
        <v-card-title v-if="datosasig != ''"> Asignados </v-card-title>
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
          ref="myTables"
          :headers="headers"
          :items="datosasig"
          :search="searchasig"
          item-key="name"
          class="elevation-1"
        >
          <template v-slot:item="row">
            <tr>
              <td>{{ row.item.id }}</td>
              <td>{{ row.item.vehi_placa }}</td>
              <td>{{ row.item.vehi_tag }}</td>
              <td>{{ row.item.vehi_tipo_vehi }}</td>
              <td>{{ row.item.mca_nombre }}</td>
              <td>{{ row.item.mod_nombre }}</td>
              <td>
                <v-tooltip v-if="row.item.asignar" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="eliminar(row.item.id)"
                      small
                      >mdi-car-off</v-icon
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
            @click="actualizar"
          >
            Asignar
          </v-btn>
        </v-card-actions>
        <v-snackbar
          bottom
          :timeout="2800"
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
  name: "asigvehi",
  props: ["id"],
  data: () => ({
    snackbar: false,
    mensaje: "",
    search: "",
    searchasig: "",
    pers_id: "",
    cedula: "",
    nombres: "",
    apellidos: "",
    unico: 0,
    color: "",
    datos: [],
    datos2: [],
    datosasig: [],
    headers: [
      { text: "Id", value: "id" },
      { text: "Placa", value: "vehi_placa" },
      { text: "Tag", value: "vehi_tag" },
      { text: "Tipo", value: "vehi_tipo_vehi" },
      { text: "Marca", value: "mca_nombre" },
      { text: "Modelo", value: "mod_nombre" },
      { text: "Acciones", value: "" },
    ],
  }),
  mounted() {
    axios
      .get(`./vehixpers/${this.id}`)
      .then((res) => {
        this.datos2 = res.data;
        this.pers_id = res.data.persona[0].pers_id;
        this.cedula = res.data.persona[0].pers_cedula;
        this.nombres = res.data.persona[0].pers_nombres;
        this.apellidos = res.data.persona[0].pers_apellidos;
        const asig = res.data.permisosuser.find(
          (el) => el.name === "perso.user.asigauto"
        );
        this.unico = res.data.number;
        if (res.data.number != 0) {
          this.datosasig = res.data.persona.map((vehi) => {
            return {
              id: vehi.id,
              vehi_placa: vehi.vehi_placa,
              vehi_tag: vehi.vehi_tag,
              vehi_tipo_vehi: vehi.vehi_tipo_vehi,
              mca_nombre: vehi.mca_nombre,
              mod_nombre: vehi.mod_nombre,
              vehi_pers_id: vehi.vehi_pers_id,
              asignar: asig ? true : false,
            };
          });
        }
        this.datos = res.data.vehi.map((vehi) => {
          return {
            id: vehi.id,
            vehi_placa: vehi.vehi_placa,
            vehi_tag: vehi.vehi_tag,
            vehi_tipo_vehi: vehi.vehi_tipo_vehi,
            mca_nombre: vehi.mca_nombre,
            mod_nombre: vehi.mod_nombre,
            vehi_pers_id: vehi.vehi_pers_id,
            asignar: asig ? true : false,
          };
        });
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = er.response.data.mensaje;
        this.snackbar = true;
      });
  },
  methods: {
    regresar() {
      setTimeout(() => this.$router.push({ name: "indexpersona" }), 2800);
    },
    asignar(id) {
      if (this.datosasig.length < 1) {
        this.datosasig.push(this.datos.find((element) => element.id == id));
        this.datos = this.datos.filter((item) => item.id !== id);
      } else {
        this.color = "red accent-2";
        this.mensaje = "No puedes asignar mas de 2 automóvil";
        this.snackbar = true;
      }
    },
    eliminar(id) {
      this.datos.push(this.datosasig.find((element) => element.id == id));
      this.datosasig = this.datosasig.filter((item) => item.id !== id);
    },
    actualizar() {
      /* this.datosasig = this.datosasig.map((dat) => {
        return { ...dat };
      }); */

      axios
        .put(`./vehixpers/${this.id}/${this.unico}`, this.datosasig)
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