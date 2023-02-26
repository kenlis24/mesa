<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center" v-if="datosasig != ''">
      <v-card class="mt-12 mx-auto">
        <v-card-title>Fecha: {{ fecha }}</v-card-title>
        <v-card-title>Estación: {{ institucion }} {{ fecha }}</v-card-title>
        <v-card-title v-if="datosasig != ''">
          Reporte Asignados y despachados por estación</v-card-title
        >
        <v-col cols="12" sm="4">          
          <v-btn color="primary" class="mr-4" @click="createPDF(fecha,institucion)">
            Generar PDF
          </v-btn>
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
          ref="myTable"
          :headers="headers"
          :items="datosasig"
          :search="searchasig"
          item-key="name"
          class="elevation-1"
        >
        </v-data-table>
        <v-card-actions>
          <v-spacer></v-spacer>
        </v-card-actions>
        <v-snackbar v-model="snack" :timeout="3000" :color="snackColor">
          {{ snackText }}

          <template v-slot:action="{ attrs }">
            <v-btn v-bind="attrs" text @click="snack = false"> Close </v-btn>
          </template>
        </v-snackbar>
      </v-card>
    </v-row>
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
  </v-container>
</template>
<script>
import jsPDF from 'jspdf';
import 'jspdf-autotable';
export default {
  name: "despasigxesta",
  props: ["fecha", "insti"],
  data: () => ({
    snackbar: false,
    snack: false,
    snackColor: "",
    snackText: "",
    mensaje: "",
    search: "",
    searchasig: "",
    color: "",
    institucion: "",
    datos: [],
    observ: "",
    datosasig: [],
    tipov: {},
    litrospagaRules: [
      (v) => v <= 999 || "Máximo 999",
      (v) => v > 0 || "Mínimo 0",
    ],
    tipoitems: [
      { id: "1", nombre: "Automóvil" },
      { id: "2", nombre: "Motos" },
    ],
    headers: [
      { text: "Id flota", value: "flo_id" },
      { text: "Cédula", value: "pers_cedula" },
      { text: "Nombres", value: "pers_nombres" },
      { text: "Apellidos", value: "pers_apellidos" },
      { text: "Instituto", value: "inst_nombre" },
      { text: "Modelo", value: "mod_nombre" },
      { text: "Placa", value: "vehi_placa" },
      { text: "Litros", value: "conp_lts" },
      { text: "Litros pagado", value: "litros_paga" },
      { text: "Litros despachado", value: "litros_desp" },
    ],
  }),
  mounted() {
    axios
      .get(`./progrflotaxesta/${this.fecha}/${this.insti}`)
      .then((res) => {
        this.datos = res.data;
        if (res.data.progflotactiva.length > 0) {
          this.institucion = res.data.progflot[0].inst_nombre;
        } else {
          this.color = "warning";
          this.mensaje = "La estacion no contiene flota asignada";
          this.snackbar = true;
        }
        //para los ya programados de la flota
        this.datosasig = res.data.progflotactiva.map((progact) => {
          const asig = res.data.permisosuser.find(
            (el) => el.name === "despaxesta.user.edit"
          );
          this.litros += progact.conp_lts;
          return {
            flo_id: progact.flo_id,
            inst_nombre: progact.inst_nombre,
            pers_cedula: progact.pers_cedula,
            pers_nombres: progact.pers_nombres,
            pers_apellidos: progact.pers_apellidos,
            mca_nombre: progact.mca_nombre,
            mod_nombre: progact.mod_nombre,
            vehi_placa: progact.vehi_placa,
            conp_lts: progact.conp_lts,
            litros_paga: progact.pflo_litros_paga,
            litros_desp: progact.pflo_litros_desp,
            pflo_prog_id: progact.pflo_prog_id,
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
   createPDF (fecha,institucion) {   
       
            var source =  this.$refs["myTable"];
            var TotalLitros=0;
            var TotalLitrosPaga=0;
            var TotalLitrosDesp=0;
            var TotalVehiculosPagaron=0;
            var TotalVehiculosDespa=0;
            let rows = [];
            let columnHeader = ['Id flota', 'Cedula', 'Nombre y Apellido', 'Intituto', 'Modelo', 'Placa', 'Litros', 'Litros pagados', 'Litros Despachados'];
            let pdfName = 'Reporte Asignados y despachados estación'+ ' ' +institucion + ' ' +fecha;
            source.items.forEach(element => {
                var temp = [
                    element.flo_id,                    
                    element.pers_cedula,
                    element.pers_nombres+' '+element.pers_apellidos,
                    element.inst_nombre,
                    element.mod_nombre, 
                    element.vehi_placa,                    
                    element.conp_lts, 
                    element.litros_paga, 
                    element.litros_desp, 
                ];
                TotalLitros= TotalLitros + element.conp_lts;
                TotalLitrosPaga= TotalLitrosPaga + element.litros_paga;
                TotalLitrosDesp= TotalLitrosDesp + element.litros_desp;
                if(element.litros_paga!=0)
                {
                  TotalVehiculosPagaron = TotalVehiculosPagaron + 1;
                }
                if(element.litros_desp!=0)
                {
                  TotalVehiculosDespa = TotalVehiculosDespa + 1;
                }
                rows.push(temp);                
            });
            var doc = new jsPDF('landscape');
            const fecha2 = new Date();          
            var header = function () {
              doc.setFontSize(13);
              doc.text( 20, 10, 'Mesa de Combustible','left') ;    
              doc.text( 280, 10, 'Fecha: '+fecha2.toLocaleDateString(),'right') ;      
              doc.text( 20, 15, 'Táchira','left');
              doc.setFontSize(13);
              doc.text( 150, 20, 'Reporte Asignados y despachados estación ' + ' ' +institucion + ' ' +fecha,'center') ;
              doc.setLineWidth(5);
            };  
             var footer = function () {   
                doc.setFontSize(10);  
                var pageCount = doc.internal.getNumberOfPages();
                doc.text(150,200,'Página: ' + ' ' +pageCount,'center');
             };
            doc.autoTable(columnHeader, rows, { startY: 30, beforePageContent: header, afterPageContent: footer, margin: {
                top: 30  }, styles: { minCellHeight: 10 } });
            doc.addPage();
            doc.setFontSize(13);
              doc.text( 20, 10, 'Mesa de Combustible','left') ;    
              doc.text( 280, 10, 'Fecha: '+fecha2.toLocaleDateString(),'right') ;      
              doc.text( 20, 15, 'Táchira','left');
              doc.setFontSize(12);
              doc.text( 150, 20, 'Reporte Asignados y despachados estación ' + ' ' +institucion + ' ' +fecha,'center') ;
              doc.setLineWidth(15);
            doc.text( 20, 40, 'Total de litros Programados: ' + ' ' +TotalLitros,'left');
            doc.text( 20, 50, 'Total de litros Pagados: ' + ' ' +TotalLitrosPaga,'left');
            doc.text( 20, 60, 'Total de litros Despachados: ' + ' ' +TotalLitrosDesp,'left');
            doc.text( 20, 70, 'Total Vehiculos pagaron: ' + ' ' +TotalVehiculosPagaron,'left');
            doc.text( 20, 80, 'Total Vehiculos despacharon: ' + ' ' +TotalVehiculosDespa,'left');
            doc.setFontSize(10); 
            var pageCount = doc.internal.getNumberOfPages();
            doc.text(150,200,'Página: ' + ' ' +pageCount,'center');
            doc.save(pdfName + '.pdf');
        }
  },
};
</script>