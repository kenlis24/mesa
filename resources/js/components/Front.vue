<template>
  <v-app id="inspire">
    <v-app id="inspire">
      <v-navigation-drawer v-if="$store.state.auth" v-model="drawer" app>
        <v-list-item>
          <v-list-item-avatar>
            <v-img src="https://randomuser.me/api/portraits/men/78.jpg"></v-img>
          </v-list-item-avatar>

          <v-list-item-content>
            <v-list-item-title>{{ $store.state.user.name }}</v-list-item-title>
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
        <v-toolbar-title>OPT</v-toolbar-title>
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
                Inicar
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
      correo: "admin@admin.com",
      mostrarPass: false,
      clave: "admin123",
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
          title: "usuarios",
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
          title: "About",
          icon: "mdi-forum",
          url: "#",
          permiso: "admin.user.index",
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