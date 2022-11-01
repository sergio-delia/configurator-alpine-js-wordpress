<?php

add_action("wp_enqueue_scripts", "registerAssetsConfiguratore");

function registerAssetsConfiguratore()
{
  wp_register_script('alpinejs', get_theme_file_uri() . '/configuratore/vendor/alpine.min.js', array(), '2.7.3', false);

  // Meterialize
  wp_register_style('materialize_css', get_theme_file_uri() . '/configuratore/vendor/materialize/css/materialize.min.css',  array(), '1.0.0',  'all');
  wp_register_script('materialize_js', get_theme_file_uri() . '/configuratore/vendor/materialize/js/materialize.js', array('jquery'), microtime(), true);
  wp_register_script('custom_configuratore_js', get_theme_file_uri() . '/configuratore/vendor/custom_configuratore.js', array('jquery'), microtime(), true);
  //wp_register_script('combinazioni_js', get_theme_file_uri() . '/configuratore/combinazioni.js', array(), microtime(), true);
}


/* Shortcode configuratore */


add_shortcode('basica_configuratore', 'basica_configuratore_cb');

function basica_configuratore_cb($atts)
{


  wp_enqueue_style('materialize_css');
  wp_enqueue_script('materialize_js');
  wp_enqueue_script('alpinejs');
  wp_enqueue_script('custom_configuratore_js');
  //wp_enqueue_script('combinazioni_js');

  extract(
    shortcode_atts(
      array(
        'parametro_1' => '',
        'parametro_2' => ''
      ),
      $atts
    )
  );

  ob_start();
?>

  <!-- HTML -->
  <style>
    li.cc_configurator_option_change {
      display: inline;
    }

    img.conf_cerchio_img.active {
      border: 2px solid green;
      border-radius: 5px;
      padding: 2px;
    }

    img.conf_cerchio_img {
      width: 2.5rem;
      cursor: pointer;
    }
  </style>



  <h1>Dentro Shortcode configuratore</h1>
  <div class="container" x-data="Basica_configuratore()" x-init="initBasica()">
    <div class="row">
      <!-- TABS -->
      <div class="col s12">
        <ul class="tabs">
          <li @click="setView('front')" :class="{ 'active': current_view == 'front'}" class="tab col s3"><a href="#front">Front</a></li>
          <li @click="setView('back')" :class="{ 'active': current_view == 'back'}" class=" tab col s3"><a href="#back">Back</a></li>

        </ul>
      </div>
      <div class="col s12 m12 l7 xl7">
        <div class="row">
          <div class="col s12">
            <div class="card">
              <div class="card-image">
                <img x-bind:src="[img_front_url]" width="100%">
                <span class="card-title">Card Title</span>
              </div>
              <div class="card-content">
                <p>Test</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col s12 m12 l5 xl5">
        <div class="input-field col s12">
          <select @change="select_change()" x-model="modello_auto">
            <option value="*">Seleziona il modello</option>
            <option value="confort_evo500">Modello Confort/Evo500</option>
            <option value="modello_st">Modello ST</option>
            <option value="modello_sportline_sport_erre">Modello Sportline/Sport Erre</option>
          </select>
          <label>MODELLO CH</label>
        </div>

        <div>
          <b>Tetto e specchi</b>
          <ul id="conf_tettoespecchi">
            <li class="cc_configurator_option_change" data-color="nero">
              <img @click="setTetto('nero')" :class="{'active' : tetto_selezionato == 'nero'}" class="conf_cerchio_img" src="https://www.chatenetitalia.it/wp-content/uploads/2020/05/ic-1.png">
            </li>
            <li class="cc_configurator_option_change cc_configurator_option_selected" data-color="grigio">
              <img @click="setTetto('grigio')" :class="{'active' : tetto_selezionato == 'grigio'}" class="conf_cerchio_img" src="https://www.chatenetitalia.it/wp-content/uploads/2020/06/grigio.png">
            </li>
          </ul>
        </div>

        <div>
          <b>Carrozzeria</b>
          <ul id="conf_carrozzeria">
            <li class="cc_configurator_option_change cc_configurator_option_selected" data-color="bianco">
              <img @click="setCarrozzeria('bianco')" :class="{'active' : carrozzeria_selezionata == 'bianco'}" class="conf_cerchio_img" src="https://www.chatenetitalia.it/wp-content/uploads/2020/07/color-white@2x-e1594029097360.png">
            </li>
            <li class="cc_configurator_option_change" data-color="grigio">
              <img @click="setCarrozzeria('grigio')" :class="{'active' : carrozzeria_selezionata == 'grigio'}" class="conf_cerchio_img" src="https://www.chatenetitalia.it/wp-content/uploads/2020/07/color-grey@2x-e1594029313407.png">
            </li>
            <li class="cc_configurator_option_change" data-color="nero">
              <img @click="setCarrozzeria('nero')" :class="{'active' : carrozzeria_selezionata == 'nero'}" class="conf_cerchio_img" src="https://www.chatenetitalia.it/wp-content/uploads/2020/07/color-black-matte@2x-e1594029371505.png">
            </li>
            <li class="cc_configurator_option_change" data-color="rosso">
              <img @click="setCarrozzeria('rosso')" :class="{'active' : carrozzeria_selezionata == 'rosso'}" class="conf_cerchio_img" src="https://www.chatenetitalia.it/wp-content/uploads/2020/06/rosso.png">
            </li>
            <li class="cc_configurator_option_change" data-color="neroOpaco">
              <img @click="setCarrozzeria('neroOpaco')" :class="{'active' : carrozzeria_selezionata == 'neroOpaco'}" class="conf_cerchio_img" src="https://www.chatenetitalia.it/wp-content/uploads/2020/07/color-black@2x-e1594029422577.png">
            </li>
          </ul>
        </div>

        <div>
          <b>Strisce</b>
          <ul id="conf_strisce">
            <li class="cc_configurator_option_change cc_configurator_option_selected" data-color="NOstrisce"><span>
                <img @click="setStrisce('NOstrisce')" :class="{'active' : strisce_selezionate == 'NOstrisce'}" class="conf_cerchio_img" alt="No strisce"></span>
            </li>
            <li class="cc_configurator_option_change" data-color="oro">
              <img @click="setStrisce('oro')" :class="{'active' : strisce_selezionate == 'oro'}" class="conf_cerchio_img" src="https://www.chatenetitalia.it/wp-content/uploads/2020/06/color-gold-matte-e1593439888692.png">
            </li>
            <li class="cc_configurator_option_change" data-color="rosso">
              <img @click="setStrisce('rosso')" :class="{'active' : strisce_selezionate == 'rosso'}" class="conf_cerchio_img" src="https://www.chatenetitalia.it/wp-content/uploads/2020/06/rosso.png">
            </li>
            <li class="cc_configurator_option_change" data-color="verdefluo">
              <img @click="setStrisce('verdefluo')" :class="{'active' : strisce_selezionate == 'verdefluo'}" class="conf_cerchio_img" src="https://www.chatenetitalia.it/wp-content/uploads/2020/06/color-green-matte@2x-e1593440382178.png">
            </li>
            <li class="cc_configurator_option_change" data-color="" data-nome="">
              <img @click="setStrisce('')">
            </li>
            <li class="cc_configurator_option_change" data-color="" data-nome="">
              <img @click="setStrisce('')">
            </li>
          </ul>
        </div>

      </div>


    </div>
  </div>



  <script>
    function Basica_configuratore() {
      return {
        /*nome: "Sergio",
        cognome: "D'Elia",
        getName(){
            return this.nome + ' ' + this.cognome;
        } */

        modello_auto: '*', //modello_auto è il nome del modello dato con x-model alla select
        tetto_selezionato: 'nero',
        carrozzeria_selezionata: 'bianco',
        strisce_selezionate: 'NOstrisce',
        img_front_url: 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_bianco_cerchio1_NOstrisce_fronte.png',
        current_view: 'front',


        select_change() {
          //UNA SELECT PASSA IN AUTOMATICO UN EVENT
          //console.log(event.target.value);
        },


        initBasica() {
          // LA FUNZIONE DI INIT E TUTTE LE ALTRE FUNZIONI DI ALPINE DEVONO ESSERE DICHIARATE ALL'INTERNO DELLA FUNZIONE DEL X-DATA
          this.$watch('modello_auto', (val) => {
            console.log('modello_auto cambiato ' + val);
            this.validation();
          });

          this.$watch('tetto_selezionato', (val) => {
            console.log('tetto_selezionato cambiato ' + val);
            this.validation();
          });

          this.$watch('carrozzeria_selezionata', (val) => {
            console.log('carrozzeria_selezionata cambiata ' + val);
            this.validation();
          });

          this.$watch('strisce_selezionate', (val) => {
            console.log('strisce_selezionate cambiate ' + val);
            this.validation();
          });

          this.$watch('current_view', (val) => {
            console.log('current_view cambiata ' + val);
            this.validation();

          });
        },

        setTetto(colore) {
          this.tetto_selezionato = colore;
          console.log('Stai settando il tetto ' + colore);
        },

        setCarrozzeria(colore) {
          this.carrozzeria_selezionata = colore;
          console.log('Stai settando la carrozeria ' + colore);
        },

        setStrisce(colore) {
          this.strisce_selezionate = colore;
          console.log('Stai settando le strisce ' + colore);
        },

        setView(vista) {
          this.current_view = vista;
          console.log('Stai settando la vista ' + vista);
        },

        validation() {
          if (this.modello_auto != '*') {
            //Modello selezionato
            this.buildQuery();
          } else {
            //Seleziona un modello
            alert('Devi selezionare un modello auto');
          }
          //console.log('Siamo dentro validation');
        },

        buildQuery(){
          if(this.current_view == 'front'){
            //Front
            let data = JSON.parse(JSON.stringify(this.combinazioni_front));
            let modello_selezionato = data[this.modello_auto];
            let result = modello_selezionato.find((modello) => {
              return modello.tetto == this.tetto_selezionato &&
                     modello.carrozzeria == this.carrozzeria_selezionata &&
                     modello.strisce == this.strisce_selezionate;
            });

            this.img_front_url = result.url;
            

          } else {
            //Back
            let data = JSON.parse(JSON.stringify(this.combinazioni_back));
            let modello_selezionato = data[this.modello_auto];
            console.log(modello_selezionato);
            let result = modello_selezionato.find((modello) => {
              return modello.tetto == this.tetto_selezionato &&
                     modello.carrozzeria == this.carrozzeria_selezionata &&
                     modello.strisce == this.strisce_selezionate;
            });

            this.img_front_url = result.url;
          }
        },



        combinazioni_front: {
          'confort_evo500': [
            //TETTO E SPECCHIO NERO
            {
              'tetto': 'nero',
              'carrozzeria': 'bianco',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_bianco_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'bianco',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_bianco_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'bianco',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_bianco_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'bianco',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_bianco_cerchio1_verdefluo_fronte.png'
            },
            //secondo blocco
            {
              'tetto': 'nero',
              'carrozzeria': 'grigio',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_grigio_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'grigio',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_grigio_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'grigio',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_grigio_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'grigio',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_grigio_cerchio1_verdefluo_fronte.png'
            },
            //terzo blocco
            {
              'tetto': 'nero',
              'carrozzeria': 'neroOpaco',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_nero_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'neroOpaco',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_nero_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'neroOpaco',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_nero_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'neroOpaco',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_nero_cerchio1_verdefluo_fronte.png'
            },
            //quarto blocco
            {
              'tetto': 'nero',
              'carrozzeria': 'rosso',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_rosso_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'rosso',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_rosso_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'rosso',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_rosso_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'rosso',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_rosso_cerchio1_verdefluo_fronte.png'
            },
            //quinto blocco
            {
              'tetto': 'nero',
              'carrozzeria': 'nero',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_neroOpaco_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'nero',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_neroOpaco_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'nero',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_neroOpaco_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'nero',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_neroOpaco_cerchio1_verdefluo_fronte.png'
            },

            // TETTO E SPECCHIO GRIGIO
            {
              'tetto': 'grigio',
              'carrozzeria': 'bianco',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_bianco_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'bianco',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_bianco_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'bianco',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_bianco_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'bianco',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_bianco_cerchio1_verdefluo_fronte.png'
            },
            //secondo blocco
            {
              'tetto': 'grigio',
              'carrozzeria': 'grigio',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_grigio_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'grigio',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_grigio_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'grigio',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_grigio_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'grigio',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_grigio_cerchio1_verdefluo_fronte.png'
            },
            //terzo blocco
            {
              'tetto': 'grigio',
              'carrozzeria': 'neroOpaco',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_nero_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'neroOpaco',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_nero_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'neroOpaco',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_nero_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'neroOpaco',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_nero_cerchio1_verdefluo_fronte.png'
            },
            //quarto blocco da fare img
            {
              'tetto': 'grigio',
              'carrozzeria': 'rosso',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_rosso_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'rosso',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_rosso_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'rosso',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_rosso_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'rosso',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_rosso_cerchio1_verdefluo_fronte.png'
            },
            //quinto blocco
            {
              'tetto': 'grigio',
              'carrozzeria': 'nero',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_neroOpaco_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'nero',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_neroOpaco_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'nero',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_neroOpaco_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'nero',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_neroOpaco_cerchio1_verdefluo_fronte.png'
            },

          ],

          // Secondo modello chatenet st
          'modello_st': [
            //TETTO E SPECCHIO NERO
            {
              'tetto': 'nero',
              'carrozzeria': 'bianco',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_bianco_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'bianco',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_bianco_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'bianco',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_bianco_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'bianco',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_bianco_cerchio1_verdefluo_fronte.png'
            },
            //secondo blocco
            {
              'tetto': 'nero',
              'carrozzeria': 'grigio',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_grigio_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'grigio',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_grigio_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'grigio',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_grigio_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'grigio',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_grigio_cerchio1_verdefluo_fronte.png'
            },
            //terzo blocco
            {
              'tetto': 'nero',
              'carrozzeria': 'neroOpaco',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_nero_cerchio1_verdefluo_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'neroOpaco',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_nero_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'neroOpaco',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_nero_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'neroOpaco',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_nero_cerchio1_verdefluo_fronte.png'
            },
            //quarto blocco
            {
              'tetto': 'nero',
              'carrozzeria': 'rosso',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_rosso_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'rosso',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_rosso_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'rosso',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_rosso_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'rosso',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_rosso_cerchio1_verdefluo_fronte.png'
            },
            //quinto blocco
            {
              'tetto': 'nero',
              'carrozzeria': 'nero',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_neroOpaco_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'nero',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_neroOpaco_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'nero',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_neroOpaco_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'nero',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_neroOpaco_cerchio1_verdefluo_fronte.png'
            },

            // TETTO E SPECCHIO GRIGIO
            {
              'tetto': 'grigio',
              'carrozzeria': 'bianco',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_bianco_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'bianco',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_bianco_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'bianco',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_bianco_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'bianco',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_bianco_cerchio1_verdefluo_fronte.png'
            },
            //secondo blocco
            {
              'tetto': 'grigio',
              'carrozzeria': 'grigio',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_grigio_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'grigio',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_grigio_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'grigio',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_grigio_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'grigio',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_grigio_cerchio1_verdefluo_fronte.png'
            },
            //terzo blocco
            {
              'tetto': 'grigio',
              'carrozzeria': 'neroOpaco',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_nero_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'neroOpaco',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_nero_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'neroOpaco',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_nero_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'neroOpaco',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_nero_cerchio1_verdefluo_fronte.png'
            },
            //quarto blocco
            {
              'tetto': 'grigio',
              'carrozzeria': 'rosso',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_rosso_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'rosso',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_rosso_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'rosso',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_rosso_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'rosso',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_rosso_cerchio1_verdefluo_fronte.png'
            },
            //quinto blocco
            {
              'tetto': 'grigio',
              'carrozzeria': 'nero',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_neroOpaco_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'nero',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_neroOpaco_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'nero',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_neroOpaco_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'nero',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_neroOpaco_cerchio1_verdefluo_fronte.png'
            },

          ],
          // TERZO MODELLO  modello_sportline_sport_erre
          'modello_sportline_sport_erre': [
            //TETTO E SPECCHIO NERO
            {
              'tetto': 'nero',
              'carrozzeria': 'bianco',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_bianco_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'bianco',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_bianco_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'bianco',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_bianco_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'bianco',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_bianco_cerchio1_verdefluo_fronte.png'
            },
            //secondo blocco
            {
              'tetto': 'nero',
              'carrozzeria': 'grigio',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_grigio_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'grigio',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_grigio_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'grigio',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_grigio_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'grigio',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_grigio_cerchio1_verdefluo_fronte.png'
            },
            //terzo blocco
            {
              'tetto': 'nero',
              'carrozzeria': 'neroOpaco',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_nero_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'neroOpaco',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_nero_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'neroOpaco',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_nero_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'neroOpaco',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_nero_cerchio1_verdefluo_fronte.png'
            },
            //quarto blocco
            {
              'tetto': 'nero',
              'carrozzeria': 'rosso',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_rosso_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'rosso',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_rosso_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'rosso',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_rosso_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'rosso',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_rosso_cerchio1_verdefluo_fronte.png'
            },
            //quinto blocco
            {
              'tetto': 'nero',
              'carrozzeria': 'nero',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_neroOpaco_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'nero',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_neroOpaco_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'nero',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_neroOpaco_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'nero',
              'carrozzeria': 'nero',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_neroOpaco_cerchio1_verdefluo_fronte.png'
            },

            // TETTO E SPECCHIO GRIGIO
            {
              'tetto': 'grigio',
              'carrozzeria': 'bianco',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_bianco_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'bianco',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_bianco_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'bianco',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_bianco_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'bianco',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_bianco_cerchio1_verdefluo_fronte.png'
            },
            //secondo blocco
            {
              'tetto': 'grigio',
              'carrozzeria': 'grigio',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_grigio_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'grigio',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_grigio_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'grigio',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_grigio_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'grigio',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_grigio_cerchio1_verdefluo_fronte.png'
            },
            //terzo blocco
            {
              'tetto': 'grigio',
              'carrozzeria': 'neroOpaco',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_nero_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'neroOpaco',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_nero_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'neroOpaco',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_nero_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'neroOpaco',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_nero_cerchio1_verdefluo_fronte.png'
            },
            //quarto blocco
            {
              'tetto': 'grigio',
              'carrozzeria': 'rosso',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_rosso_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'rosso',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_rosso_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'rosso',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_rosso_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'rosso',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_rosso_cerchio1_verdefluo_fronte.png'
            },
            //quinto blocco
            {
              'tetto': 'grigio',
              'carrozzeria': 'nero',
              'strisce': 'NOstrisce',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_neroOpaco_cerchio1_NOstrisce_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'nero',
              'strisce': 'oro',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_neroOpaco_cerchio1_oro_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'nero',
              'strisce': 'rosso',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_neroOpaco_cerchio1_rosso_fronte.png'
            },
            {
              'tetto': 'grigio',
              'carrozzeria': 'nero',
              'strisce': 'verdefluo',
              'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_neroOpaco_cerchio1_verdefluo_fronte.png'
            },

          ]

        },

        combinazioni_back: {
            'confort_evo500': [
              //TETTO E SPECCHIO NERO
              {
                'tetto': 'nero',
                'carrozzeria': 'bianco',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_bianco_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'bianco',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_bianco_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'bianco',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_bianco_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'bianco',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_bianco_cerchio1_verdefluo_retro.png'
              },
              //secondo blocco
              {
                'tetto': 'nero',
                'carrozzeria': 'grigio',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_grigio_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'grigio',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_grigio_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'grigio',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_grigio_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'grigio',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_grigio_cerchio1_verdefluo_retro.png'
              },
              //terzo blocco
              {
                'tetto': 'nero',
                'carrozzeria': 'neroOpaco',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_nero_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'neroOpaco',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_nero_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'neroOpaco',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_nero_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'neroOpaco',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_nero_cerchio1_verdefluo_retro.png'
              },
              //quarto blocco
              {
                'tetto': 'nero',
                'carrozzeria': 'rosso',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_rosso_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'rosso',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_rosso_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'rosso',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_rosso_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'rosso',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_rosso_cerchio1_verdefluo_retro.png'
              },
              //quinto blocco
              {
                'tetto': 'nero',
                'carrozzeria': 'nero',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_neroOpaco_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'nero',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_neroOpaco_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'nero',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_neroOpaco_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'nero',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_nero_neroOpaco_cerchio1_verdefluo_retro.png'
              },

              // TETTO E SPECCHIO GRIGIO
              {
                'tetto': 'grigio',
                'carrozzeria': 'bianco',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_bianco_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'bianco',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_bianco_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'bianco',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_bianco_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'bianco',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_bianco_cerchio1_verdefluo_retro.png'
              },
              //secondo blocco
              {
                'tetto': 'grigio',
                'carrozzeria': 'grigio',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_grigio_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'grigio',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_grigio_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'grigio',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_grigio_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'grigio',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_grigio_cerchio1_verdefluo_retro.png'
              },
              //terzo blocco
              {
                'tetto': 'grigio',
                'carrozzeria': 'neroOpaco',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_nero_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'neroOpaco',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_nero_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'neroOpaco',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_nero_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'neroOpaco',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_nero_cerchio1_verdefluo_retro.png'
              },
              //quarto blocco da fare img
              {
                'tetto': 'grigio',
                'carrozzeria': 'rosso',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_rosso_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'rosso',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_rosso_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'rosso',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_rosso_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'rosso',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_rosso_cerchio1_verdefluo_retro.png'
              },
              //quinto blocco
              {
                'tetto': 'grigio',
                'carrozzeria': 'nero',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_neroOpaco_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'nero',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_neroOpaco_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'nero',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_neroOpaco_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'nero',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46confort_grigio_neroOpaco_cerchio1_verdefluo_retro.png'
              },

            ],

            // Secondo modello chatenet st
            'modello_st': [
              //TETTO E SPECCHIO NERO
              {
                'tetto': 'nero',
                'carrozzeria': 'bianco',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_bianco_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'bianco',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_bianco_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'bianco',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_bianco_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'bianco',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_bianco_cerchio1_verdefluo_retro.png'
              },
              //secondo blocco
              {
                'tetto': 'nero',
                'carrozzeria': 'grigio',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_grigio_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'grigio',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_grigio_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'grigio',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_grigio_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'grigio',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_grigio_cerchio1_verdefluo_retro.png'
              },
              //terzo blocco
              {
                'tetto': 'nero',
                'carrozzeria': 'neroOpaco',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_nero_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'neroOpaco',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_nero_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'neroOpaco',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_nero_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'neroOpaco',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_nero_cerchio1_verdefluo_retro.png'
              },
              //quarto blocco
              {
                'tetto': 'nero',
                'carrozzeria': 'rosso',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_rosso_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'rosso',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_rosso_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'rosso',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_rosso_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'rosso',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_rosso_cerchio1_verdefluo_retro.png'
              },
              //quinto blocco
              {
                'tetto': 'nero',
                'carrozzeria': 'nero',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_neroOpaco_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'nero',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_neroOpaco_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'nero',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_neroOpaco_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'nero',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_nero_neroOpaco_cerchio1_verdefluo_retro.png'
              },

              // TETTO E SPECCHIO GRIGIO
              {
                'tetto': 'grigio',
                'carrozzeria': 'bianco',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_bianco_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'bianco',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_bianco_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'bianco',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_bianco_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'bianco',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_bianco_cerchio1_verdefluo_retro.png'
              },
              //secondo blocco
              {
                'tetto': 'grigio',
                'carrozzeria': 'grigio',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_grigio_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'grigio',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_grigio_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'grigio',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_grigio_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'grigio',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_grigio_cerchio1_verdefluo_retro.png'
              },
              //terzo blocco
              {
                'tetto': 'grigio',
                'carrozzeria': 'neroOpaco',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_nero_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'neroOpaco',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_nero_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'neroOpaco',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_nero_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'neroOpaco',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_nero_cerchio1_verdefluo_retro.png'
              },
              //quarto blocco
              {
                'tetto': 'grigio',
                'carrozzeria': 'rosso',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_rosso_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'rosso',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_rosso_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'rosso',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_rosso_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'rosso',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_rosso_cerchio1_verdefluo_retro.png'
              },
              //quinto blocco
              {
                'tetto': 'grigio',
                'carrozzeria': 'nero',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_neroOpaco_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'nero',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_neroOpaco_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'nero',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_neroOpaco_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'nero',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46st_grigio_neroOpaco_cerchio1_verdefluo_retro.png'
              },

            ],
            // TERZO MODELLO  modello_sportline_sport_erre
            'modello_sportline_sport_erre': [
              //TETTO E SPECCHIO NERO
              {
                'tetto': 'nero',
                'carrozzeria': 'bianco',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_bianco_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'bianco',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_bianco_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'bianco',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_bianco_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'bianco',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_bianco_cerchio1_verdefluo_retro.png'
              },
              //secondo blocco
              {
                'tetto': 'nero',
                'carrozzeria': 'grigio',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_grigio_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'grigio',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_grigio_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'grigio',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_grigio_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'grigio',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_grigio_cerchio1_verdefluo_retro.png'
              },
              //terzo blocco
              {
                'tetto': 'nero',
                'carrozzeria': 'neroOpaco',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_nero_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'neroOpaco',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_nero_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'neroOpaco',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_nero_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'neroOpaco',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_nero_cerchio1_verdefluo_retro.png'
              },
              //quarto blocco
              {
                'tetto': 'nero',
                'carrozzeria': 'rosso',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_rosso_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'rosso',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_rosso_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'rosso',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_rosso_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'rosso',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_rosso_cerchio1_verdefluo_retro.png'
              },
              //quinto blocco
              {
                'tetto': 'nero',
                'carrozzeria': 'nero',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_neroOpaco_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'nero',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_neroOpaco_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'nero',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_neroOpaco_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'nero',
                'carrozzeria': 'nero',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_nero_neroOpaco_cerchio1_verdefluo_retro.png'
              },

              // TETTO E SPECCHIO GRIGIO
              {
                'tetto': 'grigio',
                'carrozzeria': 'bianco',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_bianco_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'bianco',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_bianco_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'bianco',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_bianco_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'bianco',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_bianco_cerchio1_verdefluo_retro.png'
              },
              //secondo blocco
              {
                'tetto': 'grigio',
                'carrozzeria': 'grigio',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_grigio_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'grigio',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_grigio_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'grigio',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_grigio_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'grigio',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_grigio_cerchio1_verdefluo_retro.png'
              },
              //terzo blocco
              {
                'tetto': 'grigio',
                'carrozzeria': 'neroOpaco',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_nero_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'neroOpaco',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_nero_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'neroOpaco',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_nero_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'neroOpaco',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_nero_cerchio1_verdefluo_retro.png'
              },
              //quarto blocco
              {
                'tetto': 'grigio',
                'carrozzeria': 'rosso',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_rosso_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'rosso',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_rosso_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'rosso',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_rosso_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'rosso',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_rosso_cerchio1_verdefluo_retro.png'
              },
              //quinto blocco
              {
                'tetto': 'grigio',
                'carrozzeria': 'nero',
                'strisce': 'NOstrisce',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_neroOpaco_cerchio1_NOstrisce_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'nero',
                'strisce': 'oro',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_neroOpaco_cerchio1_oro_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'nero',
                'strisce': 'rosso',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_neroOpaco_cerchio1_rosso_retro.png'
              },
              {
                'tetto': 'grigio',
                'carrozzeria': 'nero',
                'strisce': 'verdefluo',
                'url': 'https://www.chatenetitalia.it/wp-content/uploads/configuratore/ch46sportline_grigio_neroOpaco_cerchio1_verdefluo_retro.png'
              },

            ]

          },


      }
    }
  </script>


<?php
  return ob_get_clean();
}
