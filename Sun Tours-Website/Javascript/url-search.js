countrys = ['Spanje','Turkije1','Turkije2','Egypte','Frankrijk'];
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

function show_vervoer(){
  document.getElementById("vliegen_div").innerHTML='<label>vliegmaatschapij:</label><br> <select name="airlines" id="airlines"> <option value="keuze" disabled selected>-</option> <option value="KLM">KLM</option> <option value="Air spain">Air spain</option> <option value="Ryan air">Ryan air</option> <option value="Iberia">Iberia</option> </select><Br><Br> <label>vertrek vliegveld:</label><br> <select name="Vertrek_vliegveld" id="Vertrek_vliegveld"> <option value="keuze" disabled selected>-</option> <option value="KLM">Schiphol</option> <option value="Air spain">Eindhoven</option> <option value="Ryan air">Groningen-Eelde</option> <option value="Iberia">Rotterdam-The Hague</option> </select><Br><Br><label>Vlucht tijden:</label><br> <label>Heenreis:</label> <select name="Vertrek_tijd" id="Vertrek_tijd"> <option value="keuze" disabled selected>-</option> <option value="8.' + html_script_vliegen[country];
}
function hide_vervoer(){
  document.getElementById("vliegen_div").innerHTML='';
}
function show_autoverhuur(){
  document.getElementById("autos").innerHTML='test';
}
function hide_autoverhuur(){
  document.getElementById("autos").innerHTML='';
}
function test(){
  var e = document.getElementById("auto");
  var value = e.options[e.selectedIndex].value;
  console.log(value);
  document.getElementById("auto_prijs").innerHTML='€234';
}





 





