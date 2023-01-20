<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <div class="text-center text-h6">Información trabajadores</div>
        <div class="text-right">
          <v-btn v-if="create" outlined color="indigo" @click="registrar()">
            <v-icon dense>mdi-plus</v-icon>
            Registrar Trabajador
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
              <td>{{ row.item.trab_tipo_trabajador }}</td>
              <td>{{ row.item.pers_cedula }}</td>
              <td>{{ row.item.pers_nombres }}</td>
              <td>{{ row.item.pers_apellidos }}</td>
              <td>{{ row.item.inst_nombre }}</td>
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
                      @click="desactivar(row.item.id, row.item.trab_estado)"
                      small
                      :color="row.item.trab_estado == 'A' ? 'blue' : 'red'"
                      >mdi-cancel</v-icon
                    >
                  </template>
                  <span
                    v-text="
                      row.item.trab_estado == 'A' ? 'Desactivar' : 'Activar'
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
  name: "indextrabajador",
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
      { text: "Tipo", value: "trab_tipo_trabajador" },
      { text: "Cédula", value: "pers_cedula" },
      { text: "Nombres", value: "pers_nombres" },
      { text: "Apellidos", value: "pers_apellidos" },
      { text: "Institución", value: "inst_nombre" },
      { text: "Acciones", value: "" },
    ],
  }),
  mounted() {
    axios
      .get("./trabajador")
      .then((res) => {
        //this.datos2 = res.data.roles;
        this.datos = res.data.trabajadores.map((trab) => {
          const edit = res.data.permisosuser.find(
            (el) => el.name === "trab.user.edit"
          );
          const desactivar = res.data.permisosuser.find(
            (el) => el.name === "trab.user.desactivar"
          );
          const crear = res.data.permisosuser.find(
            (el) => el.name === "trab.user.create"
          );
          if (crear) this.create = true;
          var tipo = "";
          if (trab.trab_tipo_trabajador == 1) tipo = "Empleado";
          if (trab.trab_tipo_trabajador == 2) tipo = "Directivo";
          if (trab.trab_tipo_trabajador == 3) tipo = "Enlace";
          return {
            id: trab.id,
            trab_tipo_trabajador: tipo,
            pers_cedula: trab.pers_cedula,
            pers_nombres: trab.pers_nombres,
            pers_apellidos: trab.pers_apellidos,
            inst_nombre: trab.inst_nombre,
            trab_estado: trab.trab_estado,
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
      this.$router.push({ name: "trabajadoredit", params: { id: id } });
    },
    desactivar(id, acti) {
      axios
        .put(`./trabajadordesac/${id}/${acti}`)
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
      this.$router.push({ name: "trabajadorregist" });
    },
    cargar() {
      axios
        .get("./trabajador")
        .then((res) => {
          //this.datos2 = res.data.roles;
          this.datos = res.data.trabajadores.map((trab) => {
            const edit = res.data.permisosuser.find(
              (el) => el.name === "trab.user.edit"
            );
            const desactivar = res.data.permisosuser.find(
              (el) => el.name === "trab.user.desactivar"
            );
            const crear = res.data.permisosuser.find(
              (el) => el.name === "trab.user.create"
            );
            if (crear) this.create = true;
            var tipo = "";
            if (trab.trab_tipo_trabajador == 1) tipo = "Empleado";
            if (trab.trab_tipo_trabajador == 2) tipo = "Directivo";
            if (trab.trab_tipo_trabajador == 3) tipo = "Enlace";
            return {
              id: trab.id,
              trab_tipo_trabajador: tipo,
              pers_cedula: trab.pers_cedula,
              pers_nombres: trab.pers_nombres,
              pers_apellidos: trab.pers_apellidos,
              inst_nombre: trab.inst_nombre,
              trab_estado: trab.trab_estado,
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