<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <div class="text-center text-h6">Información vehículos</div>
        <div class="text-right">
          <v-btn v-if="create" outlined color="indigo" @click="registrar()">
            <v-icon dense>mdi-plus</v-icon>
            Registrar Vehículo
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
            <tr>
              <td>{{ row.item.id }}</td>
              <td>{{ row.item.vehi_placa }}</td>
              <td>{{ row.item.vehi_tag }}</td>
              <td>{{ row.item.vehi_tipo_vehi }}</td>
              <td>{{ row.item.mod_nombre }}</td>
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
                <v-tooltip v-if="row.item.desact" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="desactivar(row.item.id, row.item.vehi_estado)"
                      small
                      :color="row.item.vehi_estado == 'A' ? 'blue' : 'red'"
                      >mdi-cancel</v-icon
                    >
                  </template>
                  <span
                    v-text="
                      row.item.vehi_estado == 'A' ? 'Desactivar' : 'Activar'
                    "
                  ></span>
                </v-tooltip>
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
    </v-row>
  </v-container>
</template>
<script>
export default {
  name: "indexvehiculo",
  data: () => ({
    snackbar: false,
    mensaje: "",
    id: "",
    color: "",
    search: "",
    datos: [],
    datos2: [],
    create: false,
    headers: [
      {
        text: "ID",
        align: "start",
        sortable: false,
        value: "id",
      },
      { text: "Placa", value: "vehi_placa" },
      { text: "Tag", value: "vehi_tag" },
      { text: "Tipo", value: "vehi_tipo_vehi" },
      { text: "Modelo", value: "mod_nombre" },
      { text: "Acciones", value: "" },
    ],
  }),
  mounted() {
    axios
      .get("./vehiculo")
      .then((res) => {
        //this.datos2 = res.data.roles;
        this.datos = res.data.vehiculos.map((vehi) => {
          const edit = res.data.permisosuser.find(
            (el) => el.name === "vehi.user.edit"
          );
          const desactivar = res.data.permisosuser.find(
            (el) => el.name === "vehi.user.desactivar"
          );
          const crear = res.data.permisosuser.find(
            (el) => el.name === "vehi.user.create"
          );
          if (crear) this.create = true;
          return {
            id: vehi.id,
            vehi_placa: vehi.vehi_placa,
            vehi_tag: vehi.vehi_tag,
            vehi_tipo_vehi: vehi.vehi_tipo_vehi,
            mod_nombre: vehi.mod_nombre,
            vehi_estado: vehi.vehi_estado,
            editar: edit ? true : false,
            desact: desactivar ? true : false,
          };
        });
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = er;
        this.snackbar = true;
      });
  },
  methods: {
    editar(id) {
      this.$router.push({ name: "vehiculoedit", params: { id: id } });
    },
    desactivar(id, acti) {
      axios
        .put(`./vehiculodesac/${id}/${acti}`)
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
      this.$router.push({ name: "vehiregis" });
    },
    cargar() {
      axios
        .get("./vehiculo")
        .then((res) => {
          //this.datos2 = res.data.roles;
          this.datos = res.data.vehiculos.map((vehi) => {
            const edit = res.data.permisosuser.find(
              (el) => el.name === "vehi.user.edit"
            );
            const desactivar = res.data.permisosuser.find(
              (el) => el.name === "vehi.user.desactivar"
            );
            const crear = res.data.permisosuser.find(
              (el) => el.name === "vehi.user.create"
            );
            if (crear) this.create = true;
            return {
              id: vehi.id,
              vehi_placa: vehi.vehi_placa,
              vehi_tag: vehi.vehi_tag,
              vehi_tipo_vehi: vehi.vehi_tipo_vehi,
              mod_nombre: vehi.mod_nombre,
              vehi_estado: vehi.vehi_estado,
              editar: edit ? true : false,
              desact: desactivar ? true : false,
            };
          });
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