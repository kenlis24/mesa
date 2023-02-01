<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Registrar datos persona</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-form ref="form" v-model="valido">
          <v-card-text>
            <v-row>
              <v-col class="text-left" cols="6">
                <v-text-field
                  v-model="cedula"
                  :rules="cedRules"
                  label="Cédula"
                  required
                ></v-text-field>
              </v-col>
              <v-col class="text-center" cols="6">
                <v-text-field
                  type="date"
                  v-model="dateFormatted"
                  label="Fecha Nacimiento"
                  :rules="fechaRules"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col class="text-center">
                <v-text-field
                  v-model="nombres"
                  :rules="nombresRules"
                  label="Nombres"
                  required
                ></v-text-field>
              </v-col>
              <v-col class="text-center">
                <v-text-field
                  v-model="apellidos"
                  :rules="apellidosRules"
                  label="Apellidos"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col class="text-center">
                <v-autocomplete
                  v-model="cargo"
                  :items="cargositems"
                  :rules="cargosRules"
                  item-text="car_nombre"
                  item-value="id"
                  outlined
                  dense
                  chips
                  small-chips
                  label="Cargo"
                  required
                  return-object
                ></v-autocomplete>
              </v-col>
              <v-col class="text-center">
                <v-autocomplete
                  v-model="sexo"
                  :items="sexoitems"
                  :rules="sexoRules"
                  item-text="nombre"
                  item-value="id"
                  outlined
                  dense
                  chips
                  small-chips
                  label="Sexo"
                  required
                  return-object
                ></v-autocomplete>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="6">
                <v-text-field
                  v-model="correo"
                  :rules="correoRules"
                  label="Correo"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
            <v-autocomplete
              align="center"
              justify="center"
              v-model="insti"
              :items="instiitems"
              :rules="instiRules"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Seleccione la institución"
              required
              return-object
            ></v-autocomplete>
          </v-card-text>
          <v-card-title class="justify-center blue-grey lighten-3"
            >Datos de Contacto</v-card-title
          >
          <v-card-text>
            <v-row>
              <v-col class="text-center">
                <v-text-field
                  v-model="telfcasa"
                  :rules="telfcasaRules"
                  label="Teléfono casa"
                  required
                ></v-text-field>
              </v-col>
              <v-col class="text-center">
                <v-text-field
                  v-model="telfcel"
                  :rules="telfcelRules"
                  label="Teléfono celular"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-title class="justify-center blue-grey lighten-3"
            >Datos de Residencia</v-card-title
          >
          <v-divider></v-divider>
          <v-card-text>
            <v-autocomplete
              v-model="municipio"
              :items="municipiositems"
              :rules="municipiocRules"
              item-text="mun_nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Municipios"
              @change="cambiarparr"
              required
              return-object
            ></v-autocomplete>
            <v-autocomplete
              v-model="parroquia"
              :items="parroquiasitems"
              :rules="parroquiaRules"
              item-text="par_nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Parroquias"
              @change="cambiaragr"
              required
              return-object
            ></v-autocomplete>
            <v-autocomplete
              v-model="agrupacion"
              :items="agrupacionesitems"
              :rules="agrupacionRules"
              item-text="agr_nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Agrupaciones"
              @change="cambiarcom"
              required
              return-object
            ></v-autocomplete>
            <v-autocomplete
              v-model="comunidad"
              :items="comunidadesitems"
              :rules="comunidadRules"
              item-text="com_nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Comunidades"
              required
              return-object
            ></v-autocomplete>
            <v-text-field
              v-model="calle"
              :rules="calleRules"
              label="Calle"
              required
            ></v-text-field>
            <v-text-field
              v-model="direccion"
              :rules="direccionRules"
              label="Dirección"
              required
            ></v-text-field>
            <v-textarea
              counter
              label="Observación"
              :rules="observRules"
              v-model="observ"
            ></v-textarea>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              :disabled="!valido"
              color="primary"
              class="mr-4"
              @click="validar"
            >
              Registrar
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-row>
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
  name: "personaregist",
  props: ["id"],
  data() {
    return {
      data: "",
      registrar: false,
      valido: false,
      snackbar: false,
      color: "",
      mensaje: "",
      editar: false,
      id_pers_coms: "",
      cedula: "",
      cedRules: [(v) => !!v || "Debe colocar un rif"],
      dateFormatted: "",
      fechaRules: [
        (v) => !!v || "Seleccione una fecha",
        (v) => v.length > 0 || "Seleccione una fecha",
      ],
      nombres: "",
      nombresRules: [(v) => !!v || "Debe colocar los nombres"],
      apellidos: "",
      apellidosRules: [(v) => !!v || "Debe colocar los nombres"],
      cargo: "",
      cargositems: [],
      cargosRules: [(v) => !!v || "Debe colocar un cargo"],
      correo: "",
      correoRules: [
        (v) => !!v || "El correo es requerido",
        (v) => v.length >= 7 || "El correo es minimo 7 caracteres",
        (v) => {
          const pattern =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return pattern.test(v) || "correo no valido";
        },
      ],
      sexo: "",
      sexoitems: [
        { id: "1", nombre: "Masculino" },
        { id: "2", nombre: "Femenino" },
      ],
      sexoRules: [(v) => !!v || "Seleccione un sexo"],
      telfcasa: "",
      telfcasaRules: [
        (v) => !!v || "Debe colocar in telefono de casa",
        (v) => v > 0 || "Coloque un telefono solo numeros",
      ],
      telfcel: "",
      telfcelRules: [
        (v) => !!v || "Debe colocar in telefono celular",
        (v) => v > 0 || "Coloque un telefono solo numeros",
      ],
      insti: "",
      instiRules: [(v) => !!v || "Seleccione una institución"],
      instiitems: [],
      municipio: "",
      municipiositems: [],
      municipiocRules: [(v) => !!v || "Seleccione un minicipio"],
      parroquia: "",
      parroquiasitems: [],
      parroquiaRules: [(v) => !!v || "Seleccione una parroquia"],
      agrupacion: "",
      agrupacionesitems: [],
      agrupacionRules: [(v) => !!v || "Seleccione una agrupacion"],
      comunidad: "",
      comunidadesitems: [],
      comunidadRules: [(v) => !!v || "Seleccione una comunidad"],
      calle: "",
      calleRules: [(v) => !!v || "Debe colocar una calle"],
      direccion: "",
      direccionRules: [(v) => !!v || "Debe colocar la dirección"],
      observ: "",
      observRules: [(v) => v.length <= 250 || "Maximo 250 caracteres"],
    };
  },
  mounted() {
    axios
      .get("./persona")
      .then((res) => {
        this.data = res.data;
        this.instiitems = res.data.instituciones.map((insti) => {
          return {
            id: insti.id,
            nombre: insti.inst_nombre,
          };
        });
        this.cargositems = res.data.cargos.map((car) => {
          return {
            id: car.id,
            car_nombre: car.car_nombre,
          };
        });
        this.municipiositems = res.data.municipios.map((muni) => {
          return {
            id: muni.id,
            mun_nombre: muni.mun_nombre,
            mun_codigo: muni.mun_codigo,
          };
        });
        this.parroquiasitems = res.data.parroquias.map((parro) => {
          return {
            id: parro.id,
            par_nombre: parro.par_nombre,
            par_codigo: parro.par_codigo,
          };
        });
        this.agrupacionesitems = res.data.agrupaciones.map((agru) => {
          return {
            id: agru.id,
            agr_nombre: agru.agr_nombre,
            agr_codigo: agru.agr_codigo,
          };
        });
        this.comunidadesitems = res.data.comunidades.map((comu) => {
          return {
            id: comu.id,
            com_nombre: comu.com_nombre,
            com_codigo: comu.com_codigo,
          };
        });
        this.$refs.form.resetValidation();
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = er;
        this.snackbar = true;
      });
  },
  methods: {
    cambiarparr(id) {
      this.parroquiasitems = this.data.parroquias.filter(
        (item) => item.par_codigo.slice(0, 4) == id.mun_codigo.slice(0, 4)
      );
    },
    cambiaragr(id) {
      this.agrupacionesitems = this.data.agrupaciones.filter(
        (item) => item.agr_codigo.slice(0, 6) == id.par_codigo.slice(0, 6)
      );
    },
    cambiarcom(id) {
      this.comunidadesitems = this.data.comunidades.filter(
        (item) => item.com_codigo.slice(7, 16) == id.agr_codigo.slice(0, 9)
      );
    },
    regresar() {
      setTimeout(() => this.$router.push({ name: "indexpersona" }), 2800);
    },
    validar() {
      var datos = {
        instituto: this.insti.id,
        comunidad: this.comunidad.id,
        pers_cedula: this.cedula.trim(),
        nombres: this.nombres.trim(),
        apellidos: this.apellidos.trim(),
        cargo: this.cargo.id,
        sexo: this.sexo.id,
        correo: this.correo.trim(),
        fecha_nac: this.dateFormatted,
        telfcasa: this.telfcasa.trim(),
        calle: this.calle.trim(),
        direccion: this.direccion.trim(),
        id_pers_coms: this.id_pers_coms,
        telfcel: this.telfcel.trim(),
        observ: this.observ.trim(),
      };
      axios
        .post(`./personaregist`, datos)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
          this.regresar();
        })
        .catch((er) => {
          this.color = "red accent-2";
          this.mensaje = er.response.data.mensaje;
          this.snackbar = true;
        });
    },
  },
};
</script>
