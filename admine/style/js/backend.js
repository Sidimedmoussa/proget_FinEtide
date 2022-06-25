let listvoit = document.querySelector(".voitcontdetail");
let divselvoit = document.querySelector(".selvoit");
let divselclient = document.querySelector(".selclient");
let selctTmp = document.querySelector(".tmp");
let clientContEdit = document.querySelector(".edit-contrat .client-voiture .client");
let voitContEdit = document.querySelector(".edit-contrat .client-voiture .voiture");

$(function (){
    "use struct";
    $("[placeholder]").focus(function(){
        $(this).attr("dt",$(this).attr("placeholder"));
        $(this).attr("placeholder","");
    }).blur(function(){
        $(this).attr("placeholder",$(this).attr("dt"));
    })
    $(".selvoit").click(function(){
        $(".selectvoit").show();
    })
    $(".voit-list-xmark .voit-xmark").click(function(){
        $(".selectvoit").hide();
    })
    $(".addbrands").click(function(){ 
        $(".ajoute-brand-form").show();
    })
    $(".xmark").click(function(){
        $(".ajoute-brand-form").hide();
    })
    document.addEventListener("click", function(e){
        if(e.target.hasAttribute("data-matricule")){
            divselvoit.innerHTML = `<input type='text' style="height: 25px" class="input" name='matricule' value="${e.target.getAttribute("data-matricule")}">`;
            $(".selectvoit").hide();
        }
    })
    $(".selclient").click(function(){
        $(".clientlist").show();
    })
    $(".add-nouvau-client .client-list-xmark").click(function(){
        $(".clientlist").hide();
    })
    document.addEventListener("click", function(e){
        if(e.target.hasAttribute("data-id")){
            divselclient.innerHTML = `<input type='text' style="height: 25px" class="input" name='idclient' value="${e.target.getAttribute("data-id")}">`;
            $(".clientlist").hide();
        }
    })
    //choissire le temps
    document.addEventListener("click", function(e){
        if(e.target.hasAttribute("data-tmp")){
        selctTmp.innerHTML = `<input type='text' style="height: 35px" class="input" placeholder="Saisir Le Nombre De ${e.target.getAttribute("data-tmp")}" name="${e.target.getAttribute("data-tmp")}">`;
        }
    })
    $(".archived .xmark").click(function(){
        $(".archived").hide();
    })
    $(".archive").click(function(){
        $(".archived").show();
    })
    // edit page
    $(".edit-contrat .client-voiture .client .overedit").click(function(){
        $(".clientlist-from-edit").show();
    })
    $(".clientlist-from-edit .add-nouvau-client-from-edit .client-list-xmark").click(function(){
        $(".clientlist-from-edit").hide();
    })
    document.addEventListener("click", function(e){
        if(e.target.hasAttribute("data-id-edit")){
            clientContEdit.innerHTML= `
                    <div><label>Nom Complet: </label>${e.target.getAttribute("name")}</div>
                    <div><label>TEL: </label>${e.target.getAttribute("tel")}</div>
                    <div><label>NNI: </label>${e.target.getAttribute("NNI")}</div>
                    <div><label>Adresse: </label>${e.target.getAttribute("adr")}</div>
                    <div><label>Permis: </label>${e.target.getAttribute("prm")}</div>
                    <div class="overedit" oedit=""></div>
                    <input type="hidden" value="${e.target.getAttribute("data-id-edit")}" name="clientID">`;
                    $(".clientlist-from-edit").hide();
                            
           
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.hasAttribute("oedit")){
            $(".clientlist-from-edit").show();
        }
    })
    $(".edit-contrat .client-voiture .voiture .overedit").click(function(){
        $(".voitlist-from-edit").show();
    })
    $(".voitlist-from-edit .voit-list-xmark-edit").click(function(){
        $(".voitlist-from-edit").hide();
    })
    document.addEventListener("click", function(e){
        if (e.target.hasAttribute("data-matricule-edit")){
            voitContEdit.innerHTML = `
                <div class="carimage" ><img src="${e.target.getAttribute("img")}" alt=""></div>
                <div class="details" >
                    <span>${e.target.getAttribute("data-matricule-edit")}</span>
                    <span>${e.target.getAttribute("mod")}</span>
                    <span>${e.target.getAttribute("mq")}</span>
                    <span>${e.target.getAttribute("carb")}</span>
                    <span>${e.target.getAttribute("prj")}</span>
                    <span>${e.target.getAttribute("prh")}</span>
                    <div class="overedit" ovedit=""></div>
                    <input type="hidden" value="${e.target.getAttribute("data-matricule-edit")}" name="matricule">
                    <input type="hidden" value="${e.target.getAttribute("prj")}" name="prixJ">
                    <input type="hidden" value="${e.target.getAttribute("prh")}" name="prixH">
                </div>`;
                $(".voitlist-from-edit").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.hasAttribute("ovedit")){
            $(".voitlist-from-edit").show();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "nom"){
            $(".show-error-name , .show-error-name-aj").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "nouveaupass"){
            $(".show-error-pass").hide();
        }
    })
    
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "prenom"){
            $(".show-error-prename-aj").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "nni"){
            $(".show-error-nni-aj").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "tel"){
            $(".show-error-tel-aj").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "adress"){
            $(".show-error-adr-aj").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "delivredate"){
            $(".show-error-deldate-aj").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "permis"){
            $(".show-error-permis-aj").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "dateness"){
            $(".show-error-age-aj").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "pass"){
            $(".show-error-pass-aj").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "photo"){
            $(".show-error-img-aj").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "passconf"){
            $(".show-error-passconf-aj").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "email"){
            $(".show-error-email-aj").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "dateress"){
            $(".show-error-dateress").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "duree"){
            $(".show-error-duree").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.getAttribute("name") == "type-duree"){
            $(".show-error-type-duree").hide();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.hasAttribute("ibtn-info")){
            document.querySelector(".list-informations-contrat .infos-contrat").innerHTML=`
                                <div class="client-voiture">
                                    <div class="client">
                                        <div><label>Nom Complet: </label>${e.target.getAttribute("cmp-name")}</div>
                                        <div><label>TEL: </label>${e.target.getAttribute("tel")}</div>
                                        <div><label>NNI: </label>${e.target.getAttribute("nni")}</div>
                                        <div><label>Adresse: </label>${e.target.getAttribute("adr")}</div>
                                        <div><label>Permis: </label>${e.target.getAttribute("permis")}</div>
                                    </div>   
                                    <div class="voiture">
                                        <div class="carimage" ><img src="${e.target.getAttribute("img")}" alt=""></div>
                                        <div class="details" >
                                        <span>${e.target.getAttribute("mat")}</span>
                                        <span>${e.target.getAttribute("mod")}</span>
                                        <span>${e.target.getAttribute("carb")}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="location-info">
                                    <div class="date-loc">
                                            <div class="date">${"<span style='font-weight: bold'>Duree: </span>" + e.target.getAttribute("duree") + " " + e.target.getAttribute("tduree")}</div>
                                            <div class="date">${"<span style='font-weight: bold'>De: </span>" + e.target.getAttribute("dateloc")}</div>
                                            <div class="date">${"<span style='font-weight: bold'>A: </span>" + e.target.getAttribute("dateret")}</div>
                                            <div class="date">${"<span style='font-weight: bold'>Montant: </span>" + e.target.getAttribute("prloc") + " UM"}</div>
                                    </div>
                                    <div class="carb-info">
                                      <div class="carb-prog">
                                        <p>
                                         <span style="transform: rotate(${1.8 * e.target.getAttribute("carbprog") + 135}deg)"></span>
                                         <small>${e.target.getAttribute("carbprog")}%</small>
                                        </p>
                                        <label>${e.target.getAttribute("carb")}</label>
                                       </div> 
                                    </div>
                                </div>
                            `;
                            $(".list-informations-contrat").show();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.hasAttribute("xmark-ibtn")){
            $(".list-informations-contrat").hide();
        }
    })
    // reservation
    document.addEventListener("click", function(e){
        if (e.target.hasAttribute("ibtn-info-res")){
            document.querySelector(".list-informations-reservation .infos-contrat").innerHTML=`
                                <div class="client-voiture">
                                    <div class="client">
                                        <div><label>Nom Complet: </label>${e.target.getAttribute("cmp-name")}</div>
                                        <div><label>TEL: </label>${e.target.getAttribute("tel")}</div>
                                        <div><label>NNI: </label>${e.target.getAttribute("nni")}</div>
                                        <div><label>Adresse: </label>${e.target.getAttribute("adr")}</div>
                                        <div><label>Permis: </label>${e.target.getAttribute("permis")}</div>
                                    </div>   
                                    <div class="voiture">
                                        <div class="carimage" ><img src="${e.target.getAttribute("img")}" alt=""></div>
                                        <div class="details" >
                                        <span>${e.target.getAttribute("mat")}</span>
                                        <span>${e.target.getAttribute("mod")}</span>
                                        <span>${e.target.getAttribute("carb")}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="date-loc">
                                        <div class="date">${"<span style='font-weight: bold'>Duree: </span>" + e.target.getAttribute("duree") + " " + e.target.getAttribute("tduree")}</div>
                                        <div class="date">${"<span style='font-weight: bold'>De: </span>" + e.target.getAttribute("dateloc")}</div>
                                        <div class="date">${"<span style='font-weight: bold'>A: </span>" + e.target.getAttribute("dateret")}</div>
                                </div>
                            `;
                            $(".list-informations-reservation").show();
        }
    })
    document.addEventListener("click", function(e){
        if (e.target.hasAttribute("xmark-ibtn-res")){
            $(".list-informations-reservation").hide();
        }
    })
    setTimeout(function(){
        $(".updated").hide();
    },1000)

});
// progress
let prog = document.getElementById("max");
prog.oninput = () => {
    let = dprog = prog.value - 135;
    let ddprog = dprog / 1.8;
    document.querySelector(".carb-prog p span").style.transform = `rotate(${prog.value}deg)`;
    document.querySelector(".carb-prog p small").innerText = ddprog.toFixed(2) + '%';
}
// let updated = document.querySelector(".updated");
// setTimeout(function(){
//     updated.style.display = "none";

// },1000)






//  tduree duree prloc dateret dateloc         

// let addBrand = document.querySelector(".addbrands");
// let formBrands = document.querySelector(".ajoute-brand-form");
// let unshoedFormBrands = document.querySelector(".xmark");


// addBrand.addEventListener("click",function() { formBrands.style.display = "inline-block";})
// unshoedFormBrands.onclick = function() {formBrands.style.display = "none";}
