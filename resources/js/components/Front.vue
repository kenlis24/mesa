<template>
  <v-app id="inspire">
    <v-app id="inspire">
      <v-navigation-drawer v-if="$store.state.auth" v-model="drawer" app>
        <v-list-item>
          <v-img
            max-width="20%"
            src="https://mesacombustible.freddybernalgobernador.com/freddygobernador.png"
          ></v-img>

          <v-list-item-content>
            <v-list-item-title
              >&nbsp;{{ $store.state.user.name }}</v-list-item-title
            >
          </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>

        <v-list dense>
          <v-list-item v-for="item in filtrarMenu" :key="item.title" link>
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>
                <router-link :to="{ name: item.url }">{{
                  item.title
                }}</router-link>
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
      <v-app-bar app color="primary" dark>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title>Mesa de Combustible</v-toolbar-title>
        <v-col cols="6">
          <v-img
            max-width="30%"
            src="https://mesacombustible.freddybernalgobernador.com/mesadecombustible.png"
          ></v-img>
        </v-col>
        <v-row v-if="$store.state.auth">
          <v-col class="text-right">
            {{ $store.state.user.name }}
            <v-btn text small @click="logout">Cerrar</v-btn>
          </v-col>
        </v-row>
      </v-app-bar>
      <v-main>
        <router-view></router-view>
        <v-row class="fill-height" fluid align="center" justify="center">
          <v-card class="elevation-12" v-if="!$store.state.auth">
            <v-toolbar color="primary" dark flat>
              <v-toolbar-title>Iniciar Sesión</v-toolbar-title>
              <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>
              <v-form ref="form" v-model="valido">
                <v-text-field
                  v-model="correo"
                  :rules="correoRules"
                  label="Correo"
                  required
                ></v-text-field>

                <v-text-field
                  v-model="clave"
                  :rules="claveRules"
                  :append-icon="mostrarPass ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="mostrarPass ? 'text' : 'password'"
                  label="Clave"
                  required
                  @click:append="mostrarPass = !mostrarPass"
                ></v-text-field>
              </v-form>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                v-if="!$store.state.auth"
                :disabled="!valido"
                color="primary"
                class="mr-4"
                @click="validar"
              >
                Iniciar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-row>
        <v-snackbar
          :timeout="2500"
          v-model="snackbar"
          absolute
          color="red accent-2"
          rounded="pill"
          right
        >
          {{ this.mensaje }}
        </v-snackbar>
      </v-main>
      <v-footer color="primary" app>
        <span class="white--text">&copy; 2022</span>
      </v-footer>
    </v-app>
  </v-app>
</template>
<script>
export default {
  name: "front",
  data() {
    return {
      valido: false,
      snackbar: false,
      mensaje: "",
      user: {},
      correo: "",
      mostrarPass: false,
      clave: "",
      correoRules: [
        (v) => !!v || "Correo es requerido",
        (v) => v.length >= 5 || "El usuario es minimo 5 caracteres",
        (v) => {
          const pattern =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return pattern.test(v) || "correo no valido";
        },
      ],
      claveRules: [
        (v) => !!v || "La clave es requeria",
        (v) => v.length >= 8 || "La clave debe tener minimo 8 caracteres",
      ],
      drawer: false,
      misroles: "",
      menu: [],
      items: [
        {
          title: "Usuarios",
          icon: "mdi-account-group",
          url: "users",
          permiso: "admin.user.index",
          can: false,
        },
        {
          title: "Roles",
          icon: "mdi-account-details",
          url: "roles",
          permiso: "admin.role.index",
          can: false,
        },
        {
          title: "Instituciones",
          icon: "mdi-office-building",
          url: "indexinsti",
          permiso: "insti.user.index",
          can: false,
        },
        {
          title: "Asignar instituto",
          icon: "mdi-account-cog",
          url: "indexasiginsti",
          permiso: "asiginsti.admin.index",
          can: false,
        },
        {
          title: "Programación",
          icon: "mdi-calendar-clock",
          url: "indexprogra",
          permiso: "program.user.index",
          can: false,
        },
        {
          title: "Programación Flota",
          icon: "mdi-car-2-plus",
          url: "indexproflota",
          permiso: "proflo.user.index",
          can: false,
        },
        {
          title: "Despacho",
          icon: "mdi-gas-station",
          url: "indexdespacho",
          permiso: "despacho.user.index",
          can: false,
        },
        {
          title: "Despacho por estación",
          icon: "mdi-gas-station",
          url: "indexdespaxesta",
          permiso: "despaxesta.user.index",
          can: false,
        },
        {
          title: "Despacho Reporte",
          icon: "mdi-gas-station",
          url: "indexdespaxestarep",
          permiso: "despaxesta.user.index",
          can: false,
        },
        {
          title: "Programación Flota Reporte",
          icon: "mdi-file-document-multiple-outline",
          url: "reporteproflota",
          permiso: "proflorep.user.index",
          can: false,
        },
        {
          title: "Vehiculos",
          icon: "mdi-car-cog",
          url: "indexvehiculo",
          permiso: "vehi.user.index",
          can: false,
        },
        {
          title: "Trabajadores",
          icon: "mdi-account-hard-hat-outline",
          url: "indextrabajador",
          permiso: "trab.user.index",
          can: false,
        },
        {
          title: "Personal",
          icon: "mdi-account-multiple-plus",
          url: "indexpersona",
          permiso: "perso.user.index",
          can: false,
        },
        {
          title: "Internacional",
          icon: "mdi-gas-station",
          url: "internacional",
          permiso: "inter.user.index",
          can: false,
        },
      ],
    };
  },
  created() {
    axios
      .get(`./getroles`)
      .then((res) => {
        this.menu = this.items.map((ite) => {
          const tiene = res.data.permisosuser.find(
            (perm) => perm.name === ite.permiso
          );
          return {
            title: ite.title,
            icon: ite.icon,
            url: ite.url,
            permiso: ite.permiso,
            can: tiene ? true : false,
          };
        });
        this.datos = res.data;
      })
      .catch((er) => {
        this.datos = er;
      });
  },
  computed: {
    filtrarMenu() {
      return this.menu.filter((it) => it.can == true);
    },
  },
  methods: {
    logout() {
      this.$store.dispatch("logout");
      window.location.reload();
      //this.$router.push({ name: "principal" });
    },
    iniciar() {
      this.$router.push({ name: "principal" });
    },
    validar() {
      var datos = {
        email: this.correo,
        password: this.clave,
      };
      this.$store
        .dispatch("login", datos)
        .then((res) => {
          axios
            .get(`./getroles`)
            .then((res) => {
              this.menu = this.items.map((ite) => {
                const tiene = res.data.permisosuser.find(
                  (perm) => perm.name === ite.permiso
                );
                return {
                  title: ite.title,
                  icon: ite.icon,
                  url: ite.url,
                  permiso: ite.permiso,
                  can: tiene ? true : false,
                };
              });
              this.datos = res.data;
            })
            .catch((er) => {
              this.datos = er;
            });
        })
        .catch((er) => {
          this.mensaje = "Correo o contraseña incorrecta";
          this.snackbar = true;
        });

      this.$refs.form.validate();
    },
  },
};
</script>