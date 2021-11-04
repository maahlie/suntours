//standaard waardens worden in arrays en varriabelen gestopt.
countrys = ['Spanje','Turkije1','Turkije2','Egypte','Frankrijk'];
country_prijzen = ['600','800', '500','450','950'];
auto_merken = ['Nissan', 'Opel', 'Ford', 'Volkswagen'];
auto_prijzen = ['45', '69', '36', '84'];
vlieg_reizen = ['KLM','Ryan air', 'Iberia'];
vlieg_prijzen = [500,353,467];
vakantie_prijs = 0;
vliegticket_prijs = 0;
aantal_Personen = 0;

datums = [['2-11-2021' , '10-11-2021'], ['16-11-2021', '24-11-2021'], ['7-12-2021', '15-12-2021']];

html_scripts = [
  '<div class = "card_header"><b>Hotel Best Tenerife-Spanje</b></div>Vertrek/terug reis datum en tijd opties: <Br>2-11-2021 - 9.45<Br>10-11-2021 - 10.45<Br><Br>16-11-2021 - 8.30<Br>24-11-2021 - 9-30<Br><Br>7-12-2021 - 9.45<Br>15-12-2021 - 11.00<Br><Br><div class="btn-group"><a href="./assortiment.html">Verander Selectie</a></div></div></div></div>',
  '<div class = "card_header"><b>Hotel Gold City -Turkije</b></div>Vertrek/terug reis datum en tijd opties: <Br>2-11-2021 - 10.45<br>10-11-2021 - 20.00<br><br>16-11-2021 - 9.45<br>24-11-2021 - 15.30<br><br>7-12-2021 - 19.00<br>15-12-2021 - 11.00<br><br><div class="btn-group"><a href="./assortiment.html">Verander Selectie</a></div></div></div></div>',
  '<div class = "card_header"><b>Hotel Pine Bay Holiday Resort –Turkije</b></div>Vertrek/terug reis datum en tijd opties: <Br>2-11-2021 - 17.15<Br>10-11-2021 - 15.30<Br><Br>16-11-2021 - 22.00<Br>24-11-2021 - 23.00<Br><Br>7-12-2021 - 11.15<Br>15-12-2021 - 12.00<Br><Br><div class="btn-group"><a href="./assortiment.html">Verander Selectie</a></div></div></div></div>',
  '<div class = "card_header"><b>Hotel Hilton Marsa Resort Egypte</b></div>Vertrek/terug reis datum en tijd opties: <Br>2-11-2021 - 13.20<br>10-11-2021 - 15.00<br><br>16-11-2021 - 16.00<br>24-11-2021 - 14.30<br><br>7-12-2021 - 12.45<br>15-12-2021 - 14.30<br><br><div class="btn-group"><a href="./assortiment.html">Verander Selectie</a></div></div></div></div>',
  '<div class = "card_header"><b>Disneyland Parijs Frankrijk</b></div> Vertrek/terug reis datum en tijd opties: <Br>2-11-2021 - 9.00<br>10-11-2021 - 8.30<br><br>16-11-2021 - 16.00<br>24-11-2021 - 12.45<br><br>7-12-2021 - 17.30<br>15-12-2021 - 8.45<br><br><div class="btn-group"><a href="./assortiment.html">Verander Selectie</a></div></div></div></div>'
];
country = 0;
html_script_vliegen = [
  '30">8.30</option> <option value="9.45">9.45</option> <option value="12.45">12.45</option> <option value="16.30">16.30</option> </select><br><label>Terugreis:</label> <select name="terug_tijd" id="terug_tijd"> <option value="keuze" disabled selected>-</option> <option value="8.30">8.30</option> <option value="9.45">9.15</option> <option value="12.45">12.45</option> <option value="15.30">15.30</option> </select><Br><Br>',
  '15">8.15</option> <option value="9.50">9.50</option> <option value="12.15">12.15</option> <option value="16.00">16.00</option> </select><br><label>Terugreis:</label> <select name="terug_tijd" id="terug_tijd"> <option value="keuze" disabled selected>-</option> <option value="8.15">8.15</option> <option value="9.00">9.00</option> <option value="12.30">12.30</option> <option value="16.45">16.45</option> </select><Br><Br>',
  '00">8.00</option> <option value="9.30">9.30</option> <option value="12.20">12.20</option> <option value="16.20">16.20</option> </select><br><label>Terugreis:</label> <select name="terug_tijd" id="terug_tijd"> <option value="keuze" disabled selected>-</option> <option value="8.20">8.20</option> <option value="9.00">9.00</option> <option value="12.20">12.20</option> <option value="15.20">15.20</option> </select><Br><Br>',
  '20">8.20</option> <option value="9.15">9.15</option> <option value="12.30">12.30</option> <option value="16.15">16.15</option> </select><br><label>Terugreis:</label> <select name="terug_tijd" id="terug_tijd"> <option value="keuze" disabled selected>-</option> <option value="8.45">8.45</option> <option value="9.00">9.00</option> <option value="12.15">12.15</option> <option value="16.00">60.00</option> </select><Br><Br>',
  '00">8.00</option> <option value="9.00">9.00</option> <option value="12.00">12.00</option> <option value="16.45">16.45</option> </select><br><label>Terugreis:</label> <select name="terug_tijd" id="terug_tijd"> <option value="keuze" disabled selected>-</option> <option value="8.00">8.00</option> <option value="9.00">9.00</option> <option value="12.00">12,00</option> <option value="15.45">15.45</option> </select><Br><Br>'
];

$(document).ready(function () {
  for(i=0; i < 5; i++)
{
  if(window.location.href.indexOf(countrys[i]) > -1) 
  {
    document.getElementById("selected").innerHTML=html_scripts[i];
    country = i;
  }
}
});
function onLoad(){
  hide_autoverhuur();
  hide_bus_deals();
  var url = window.location.href;
  var id  = url.substring(url.lastIndexOf('=') + 1);
  document.getElementById("packageID").value = id;
} 
function show_vervoer(){
  document.getElementById("vliegen_div").innerHTML='<label>vliegmaatschapij:</label><br> <select name="airlines" id="airlines"  onchange="update_prices()"> <option value="keuze" disabled selected>-</option> <option value="KLM">KLM</option> <option value="Ryan air">Ryan air</option> <option value="Iberia">Iberia</option> </select><Br><Br> <label>vertrek vliegveld:</label><br> <select name="Vertrek_vliegveld" id="Vertrek_vliegveld"> <option value="keuze" disabled selected>-</option> <option value="Schiphol">Schiphol</option> <option value="Eindhoven">Eindhoven</option> <option value="Groningen-Eelde">Groningen-Eelde</option> <option value="Rotterdam-The Hague">Rotterdam-The Hague</option> </select><Br><Br>';
}

function hide_vervoer(){
  document.getElementById("vliegen_div").innerHTML='';
  document.getElementById("ticketPrice").value = 0;
  vliegticket_prijs = 0;
  aantal_Personen = 0;  
  console.log("working");
  update_prices();
}

function show_autoverhuur(){
  document.getElementById("autos").style.display = "block";
}

function hide_autoverhuur(){
  document.getElementById("autos").style.display = "none";
  document.getElementById("aantal_autos").value = 0;
  document.getElementById("rental_time_chooser_id").value = 0;
  update_prices();
}

function show_bus_deals(){
  document.getElementById("bus").style.display = "block";
}

function hide_bus_deals(){
  document.getElementById("bus").style.display = "none";
  document.getElementById("aantal_Dagen").value = 0;
  document.getElementById("aantal_tickets_bus").value = 0;
  document.getElementById("bus-dates").value = 0;
}


function calculate_car_price(){
  var selectedValue = document.getElementById("auto");
  var rental_time = document.getElementById('rental_time_chooser_id').value
  var value = selectedValue.options[selectedValue.selectedIndex].value;
  for (i=0; i< auto_merken.length; i++)
  {
    if (value == auto_merken[i])
    {
      document.getElementById("carBrand").value = auto_merken[i]
      if (rental_time <= 8 && rental_time > 0)
      {
        auto_prijs = auto_prijzen[i]*rental_time;
        document.getElementById("auto_prijs").innerHTML='€' + auto_prijs * document.getElementById("aantal_autos").value;
        document.getElementById("carPrice").value = auto_prijs;
        document.getElementById("carAmount").value = document.getElementById("aantal_autos").value;
      }else{
        document.getElementById("auto_prijs").innerHTML='Prijs:-';
        document.getElementById("carAmount").value = document.getElementById("aantal_autos").value;
      }
    }
  }
}

function calculate_Bus_Price()
{
  bus_Prijs = 9.75;
  aantal_dagen = document.getElementById("aantal_Dagen").value;
  if(aantal_dagen < 1)
  {
    document.getElementById("bus_Totaal").innerHTML='Prijs:-';
    document.getElementById("busTicketAmount").value = aantal_dagen = 0;
  }
  else
  {
    if ((aantal_dagen * bus_Prijs) * document.getElementById("aantal_tickets_bus").value > 0){
      document.getElementById("bus_Totaal").innerHTML = '€' + (aantal_dagen * bus_Prijs) * document.getElementById("aantal_tickets_bus").value;
      document.getElementById("busPrice").value = bus_Prijs;
      document.getElementById("busTicketAmount").value = document.getElementById("aantal_tickets_bus").value;
    }else
    {
      document.getElementById("bus_Totaal").innerHTML='Prijs:-';
      document.getElementById("busTicketAmount").value = aantal_dagen = 0;
    }

  }
  
}

function calculate_plane_price()
{
  
  if(document.getElementById('vervoer').checked){
  aantal_Volwassenen = document.getElementById("aantal_volwassenen").value;
  aantal_Kinderen = document.getElementById("aantal_kinderen").value;
  aantal_Personen = +aantal_Volwassenen + +aantal_Kinderen;
  vakantie_prijs = aantal_Personen * country_prijzen[country];
  document.getElementById("totaal_pakket_Prijs").innerHTML ='€' + vakantie_prijs;

airlines = document.getElementById("airlines").selectedIndex;
  for (i = 1; i < 3; i++)
  {
    if (airlines == i)
    {
      vliegticket_prijs = aantal_Personen * vlieg_prijzen[i-1];
      document.getElementById("totaal_Vliegticket_Prijs").innerHTML ='€' +  vliegticket_prijs;
      document.getElementById("ticketPrice").value = vlieg_prijzen[i-1];
      if (vliegticket_prijs <= 0){
        document.getElementById("totaal_Vliegticket_Prijs").innerHTML='Prijs:-';
    document.getElementById("totaal_pakket_Prijs").innerHTML='Prijs:-';
      }
    }
  }

}
else{
  document.getElementById("totaal_Vliegticket_Prijs").innerHTML='Prijs:-';
  document.getElementById("totaal_pakket_Prijs").innerHTML='Prijs:-';
  
}
}

function totalPrice()
{
  total_price = 0;
  vars = [vakantie_prijs, vliegticket_prijs, auto_prijs * document.getElementById("aantal_autos").value, (aantal_dagen * bus_Prijs) * document.getElementById("aantal_tickets_bus").value];
  for (i = 0; i < 4; i++)
  {
    if (vars[i] > 0){
      total_price += vars[i];
    }
  }
  
  if (total_price > 0){
    document.getElementById("totaal__Reis_Prijs").innerHTML = '€' + total_price;
    document.getElementById("totalPrice").value = country_prijzen[country];
  }else{
    document.getElementById("totaal__Reis_Prijs").innerHTML = 'Prijs: -';
  }
  
}
//hier wordt de pakket prijs uitgerekend
 function calculate_pakket_prijs()
 {
  aantal_Volwassenen = document.getElementById("aantal_volwassenen").value;
  aantal_Kinderen = document.getElementById("aantal_kinderen").value;
  aantal_Personen = +aantal_Volwassenen + +aantal_Kinderen;
  vakantie_prijs = aantal_Personen * country_prijzen[country];
  //als de vakantie prijs grote is dan 0, dan wordt de prijs op de website zichtbaar.
  if (vakantie_prijs > 0){
    document.getElementById("totaal_pakket_Prijs").innerHTML ='€' + vakantie_prijs;
  }else{
    document.getElementById("totaal_pakket_Prijs").innerHTML = 'Prijs: -';
  }

 }

 function update_dates(){
   
  var selectedValue2 = document.getElementById("tijden");
  var value = selectedValue2.options[selectedValue2.selectedIndex].value;
try{
  document.getElementById("startingDate").value = datums[value-1][0];
  document.getElementById("returnDate").value = datums[value-1][1];
}catch{
//This is fine...
}
  }
  
function update_prices()
{
  update_dates()
  calculate_car_price();
  calculate_Bus_Price();
  calculate_plane_price();
  calculate_pakket_prijs();
  totalPrice();
  document.getElementById('errorMsg').style.display = "none";

}

function getDate(){
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

  today = mm + '/' + dd + '/' + yyyy;
  return today;
}

function showConfirmForm(){

  if(
    document.getElementById("aantal_volwassenen").value != 0 &&
    document.getElementById("aantal_kinderen").value != 0 &&
    document.getElementById("totaal_pakket_Prijs").innerHTML != "" &&
    document.getElementById("totaal_pakket_Prijs").innerHTML != ""
  ){

    var oReq = new XMLHttpRequest(); // New request object
    oReq.onload = function() {
      var str = this.responseText;
      if(str == '"nietIngelogd"'){
        document.getElementById('errorMsg').innerHTML = "U bent nog niet ingelogd.";
        document.getElementById('errorMsg').style.display = "inline-block";
      }else{
        document.getElementById("orderNr").innerHTML = "#" + str.substring(4,str.length-1);
            
        var strTotalPrijs = document.getElementById("totaal__Reis_Prijs").innerHTML.substring(1);
        var annuleerKost = parseFloat(strTotalPrijs) * 0.25;

        var btw = parseFloat(strTotalPrijs) * 0.21;

        document.getElementById("currentDate").innerHTML = getDate();
        document.getElementById("aantalV").innerHTML = document.getElementById("aantal_volwassenen").value;
        document.getElementById("aantalK").innerHTML = document.getElementById("aantal_kinderen").value;
        document.getElementById("pakketP").innerHTML = document.getElementById("totaal_pakket_Prijs").innerHTML;
        document.getElementById("vlucht").innerHTML = document.getElementById("totaal_Vliegticket_Prijs").innerHTML;
        document.getElementById("autoVhuur").innerHTML = document.getElementById("auto_prijs").innerHTML;
        document.getElementById("busDeal").innerHTML = document.getElementById("bus_Totaal").innerHTML;
        document.getElementById("annuleringsKosten").innerHTML = "€" + Math.round((annuleerKost + Number.EPSILON) * 100) / 100;
        document.getElementById("btw").innerHTML = "€" + Math.round((btw + Number.EPSILON) * 100) / 100;
        document.getElementById("totaalP").innerHTML = "€" + Math.round((parseFloat(strTotalPrijs) * 1.21 + Number.EPSILON) * 100) / 100;

        
        const VAB = ["vlucht", "autoVhuur", "busDeal"];

        for(i = 0; i<3; i++){
          if(document.getElementById(VAB[i]).innerHTML == "Prijs:-"){
            document.getElementById(VAB[i]).innerHTML = "n.v.t";
          }
        }

        document.getElementById("bookingOpties").style.display = 'none';
        document.getElementById("bevestigForm").style.display = 'inline-block';
      }
    };
    oReq.open("get", "php/genOrderNr.php", true);
    //                                     ^ Don't block the rest of the execution.
    //                                      Don't wait until the request finishes to
    //                                      continue.
    oReq.send();

  }else{
    document.getElementById('errorMsg').innerHTML = "Laat a.u.b geen velden leeg.";
    document.getElementById('errorMsg').style.display = "inline-block";
  }
}