<template>
  <v-container v-if="datos">
    <v-btn outlined color="indigo" @click="asignar()">Aceptar</v-btn>
    <v-card class="elevation-12">
      <v-toolbar color="primary" dark flat>
        <v-toolbar-title>Asignar roles</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-card-text>
        <label
          >Nombre
          <span class="d-flex flex-row mb-6"
            ><b>{{ datos.user.name }}</b></span
          ></label
        >
        <v-spacer></v-spacer>
        <label
          >Email
          <span class="d-flex flex-row mb-6"
            ><b>{{ datos.user.email }}</b></span
          ></label
        >

        <v-spacer></v-spacer>
        <v-simple-table fixed-header height="200px" dense>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">Roles</th>
                <th class="text-left">Activo</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in roles" :key="item.id">
                <td>{{ item.name }}</td>
                <td>
                  <span v-if="item.existe" class="ml-3">
                    <input
                      type="checkbox"
                      :id="item.id"
                      :value="item.name"
                      v-model="nuevosroles"
                    />
                  </span>
                  <span v-else class="ml-3">
                    <input
                      type="checkbox"
                      :id="item.id"
                      :value="item.name"
                      v-model="nuevosroles"
                    />
                  </span>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
      </v-card-actions>
    </v-card>
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
  </v-container>
</template>
<script>
export default {
  name: "edituser",
  props: ["id"],
  data() {
    return {
      datos: "",
      snackbar: false,
      color: "",
      roles: [],
      mensaje: "",
      nuevosroles: [],
    };
  },
  mounted() {
    axios
      .get(`./users/${this.id}/edit`)
      .then((res) => {
        this.roles = res.data.roles.map((rol) => {
          const nuevoper = res.data.permisos.find((el) => el === rol.name);
          if (nuevoper) this.nuevosroles.push(rol.name);
          return {
            id: rol.id,
            name: rol.name,
            existe: nuevoper ? true : false,
          };
        });
        this.datos = res.data;
      })
      .catch((er) => {
        this.datos = er;
      });
  },
  methods: {
    regresar() {
      setTimeout(() => this.$router.push({ name: "users" }), 2800);
    },
    asignar() {
      var rol = {
        roles: this.nuevosroles,
      };
      axios
        .put(`./users/${this.id}`, rol)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
          this.regresar();
        })
        .catch((er) => {
          this.color = "red accent-2";
          this.mensaje = er;
          this.snackbar = true;
        });
      //this.$router.push("users");
    },
  },
};
</script>