<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <div class="text-center text-h6">Información personas</div>
        <div class="text-right">
          <v-btn v-if="create" outlined color="indigo" @click="registrar()">
            <v-icon dense>mdi-plus</v-icon>
            Registrar Persona
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
              <td>{{ row.item.pers_cedula }}</td>
              <td>{{ row.item.pers_nombres }}</td>
              <td>{{ row.item.pers_apellidos }}</td>
              <td>{{ row.item.pers_telf_cel }}</td>
              <td>{{ row.item.pers_correo }}</td>
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
                <v-tooltip v-if="row.item.asigauto" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="asigvehi(row.item.id)"
                      small
                      >mdi-car-arrow-right</v-icon
                    >
                  </template>
                  <span>Asignar Vehículo</span>
                </v-tooltip>
                <v-tooltip v-if="row.item.asiginsti" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="asiginsti(row.item.ido)"
                      small
                      >mdi-office-building-outline</v-icon
                    >
                  </template>
                  <span>Asignar Instituto</span>
                </v-tooltip>
                <v-tooltip v-if="row.item.desact" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="desactivar(row.item.id, row.item.pers_estado)"
                      small
                      :color="row.item.pers_estado == 'A' ? 'blue' : 'red'"
                      >mdi-cancel</v-icon
                    >
                  </template>
                  <span
                    v-text="
                      row.item.pers_estado == 'A' ? 'Desactivar' : 'Activar'
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
  name: "indexpersona",
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
      { text: "Cédula", value: "pers_cedula" },
      { text: "Nombres", value: "pers_nombres" },
      { text: "Apellidos", value: "pers_apellidos" },
      { text: "Celular", value: "pers_telf_cel" },
      { text: "Correo", value: "pers_correo" },
      { text: "Acciones", value: "" },
    ],
  }),
  mounted() {
    axios
      .get("./persona")
      .then((res) => {
        //this.datos2 = res.data.roles;
        this.datos = res.data.personas.map((pers) => {
          const edit = res.data.permisosuser.find(
            (el) => el.name === "perso.user.edit"
          );
          const desactivar = res.data.permisosuser.find(
            (el) => el.name === "perso.user.desactivar"
          );
          const crear = res.data.permisosuser.find(
            (el) => el.name === "perso.user.create"
          );
          const asigauto = res.data.permisosuser.find(
            (el) => el.name === "perso.user.asigauto"
          );
          const asiginsti = res.data.permisosuser.find(
            (el) => el.name === "perso.user.asiginti"
          );
          if (crear) this.create = true;
          return {
            id: pers.id,
            pers_cedula: pers.pers_cedula,
            pers_nombres: pers.pers_nombres,
            pers_apellidos: pers.pers_apellidos,
            pers_telf_cel: pers.pers_telf_cel,
            pers_correo: pers.pers_correo,
            pers_estado: pers.pers_estado,
            editar: edit ? true : false,
            desact: desactivar ? true : false,
            asigauto: asigauto ? true : false,
            asiginsti: asiginsti ? true : false,
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
      this.$router.push({ name: "personaedit", params: { id: id } });
    },
    asigvehi(id) {
      this.$router.push({ name: "asigvehi", params: { id: id } });
    },
    asiginsti(id) {
      this.$router.push({ name: "persoinsti", params: { id: id } });
    },
    desactivar(id, acti) {
      axios
        .put(`./persona/${id}/${acti}`)
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
      this.$router.push({ name: "personaregist" });
    },
    cargar() {
      axios
        .get("./persona")
        .then((res) => {
          //this.datos2 = res.data.roles;
          this.datos = res.data.personas.map((pers) => {
            const edit = res.data.permisosuser.find(
              (el) => el.name === "perso.user.edit"
            );
            const desactivar = res.data.permisosuser.find(
              (el) => el.name === "perso.user.desactivar"
            );
            const crear = res.data.permisosuser.find(
              (el) => el.name === "perso.user.create"
            );
            const asigauto = res.data.permisosuser.find(
              (el) => el.name === "perso.user.asigauto"
            );
            const asiginsti = res.data.permisosuser.find(
              (el) => el.name === "perso.user.asiginti"
            );
            if (crear) this.create = true;
            return {
              id: pers.id,
              pers_cedula: pers.pers_cedula,
              pers_nombres: pers.pers_nombres,
              pers_apellidos: pers.pers_apellidos,
              pers_telf_cel: pers.pers_telf_cel,
              pers_correo: pers.pers_correo,
              pers_estado: pers.pers_estado,
              editar: edit ? true : false,
              desact: desactivar ? true : false,
              asigauto: asigauto ? true : false,
              asiginsti: asiginsti ? true : false,
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