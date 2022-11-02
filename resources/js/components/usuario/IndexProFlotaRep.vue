<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
      <v-btn @click="createPDF(fecha)" color="primary">Generar PDF</v-btn>
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
          ref="myTable"
          :headers="headers"
          :items="datos"
          :search="search"
          item-key="name"
          class="elevation-1"
        >
        {{ cont=0 }}
          <template v-slot:item="row">
            <tr
              :class="activo(row.item)"
              :title="
                activo(row.item) != ''
                  ? 'La Institución o Estacion esta inactiva'
                  : ''
              "
            >
              <td>{{ cont=cont+1 }}</td>
                       
              <td>{{ row.item.prog_nombre }}</td>  
              <td>{{ row.item.prog_cedula }}</td> 
              <td>{{ row.item.prog_inst_id }}</td>  
              <td>{{ row.item.prog_condicion }}</td> 
              <td>{{ row.item.prog_lts }}</td>
              <td>{{ row.item.prog_placa }}</td>  
              <td>{{ row.item.prog_tag }}</td>       
              <td>
                <v-tooltip v-if="row.item.asignar" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="
                        (row.item.esta_estado || row.item.inst_estado) != 'A'
                          ? ''
                          : asignar(
                              row.item.id,
                              row.item.insti_id,
                              row.item.prog_tipo_vehi
                            )
                      "
                      :disabled="
                        (row.item.esta_estado || row.item.inst_estado) != 'A'
                      "
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
import jsPDF from 'jspdf';
import 'jspdf-autotable';
export default {
  name: "indexprograflotarep",
  props: ["fecha"],
  data: () => ({
    snackbar: false,
    mensaje: "",
    search: "",
    id: "",
    color: "",
    datos: [],
    datos2: [],
    headers: [
      {
        text: "ID",
        align: "start",
        sortable: false,
        value: "id",
      },      
      { text: "Nombres y Apellidos", value: "prog_nombre" },
      { text: "Cedula", value: "prog_cedula" },
      { text: "Institución", value: "prog_inst_id" },      
      { text: "Modelo", value: "prog_condicion" },
      { text: "Litros", value: "prog_lts" },
      { text: "Placa", value: "prog_placa" },
      { text: "Tag", value: "prog_tag" },
    ],
  }),
  mounted() {
    var data = {
        fecha: this.fecha,
      };
    axios
      .post("./progrflotarep", data)
      .then((res) => {
        this.datos2 = res.data;

        this.datos = res.data.progflotrep.map((prog) => {          
          
          return {
            id: prog.flo_id,
            prog_fecha: prog.prog_fecha.slice(0, 10),
            prog_lts: prog.conp_lts,
            prog_condicion: prog.mod_nombre,
            prog_inst_id: prog.inst_nombre,
            prog_tipo_vehi: prog.mod_nombre,
            prog_inst_id_es: prog.estacion,
            esta_estado: prog.esta_estado,
            prog_placa: prog.vehi_placa,
            prog_cedula: prog.pers_cedula,
            prog_tag: prog.vehi_tag,
            prog_nombre: prog.nombre,
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
    activo(valor) {
      if (valor.inst_estado == "A" && valor.esta_estado == "A") {
        return "";
      } else return "";
    },
    createPDF (fecha) {      
            var source =  this.$refs["myTable"];
            let rows = [];
            let columnHeader = ['N°', 'Cedula', 'Nombre y Apellido', 'Intitucción', 'Modelo', 'Litros', 'Placa', 'Tag'];
            let pdfName = 'Listado Mesa de Combustible'+fecha;
            source.items.forEach(element => {
                var temp = [
                    element.id,
                    element.prog_nombre,
                    element.prog_cedula,
                    element.prog_inst_id,
                    element.prog_condicion,  
                    element.prog_lts,
                    element.prog_placa,                    
                    element.prog_tag, 
                ];
                rows.push(temp);
            });
            var doc = new jsPDF('landscape');
            const fecha2 = new Date();
             doc.setFontSize(13);
            doc.text( 20, 10, 'Mesa de Combustible','left') ;    
            doc.text( 280, 10, 'Fecha: '+fecha2.toLocaleDateString(),'right') ;          
            doc.text( 20, 15, 'Táchira','left') ;
            doc.setFontSize(13);
            doc.text( 150, 20, 'Fecha de Programación ' + fecha,'center') ;
            doc.setLineWidth(5);
            doc.autoTable(columnHeader, rows, { startY: 25 });
            doc.save(pdfName + '.pdf');
        }
  },
};
</script>