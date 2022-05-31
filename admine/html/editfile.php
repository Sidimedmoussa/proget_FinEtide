
<!-- <form action="" method="POST" class="form-horizontal edit" >
</form> -->

<div class="wrapper">
<form action="">
    <div class="title">
      Registration Form
    </div>
    <div class="form">
       <div class="inputfield">
          <label>NOM</label>
          <input type="text" name="nom" class="input" value="<?php echo $clientInfo["NOM"];?>" autocomplate="off">
       </div>  
        <div class="inputfield">
          <label>PRENOM</label>
          <input type="text" name="prenom" value="<?php echo $clientInfo["PRENOM"];?>" class="input" autocomplate="off">
       </div>  
       <div class="inputfield">
          <label>NNI</label>
          <input type="number" name="nni" value="<?php echo $clientInfo["NNI"];?>" class="input">  
       </div> 
      <div class="inputfield">
          <label>TEL</label>
          <input type="text" class="input" value="<?php echo $clientInfo["TEL"];?>" name="tel" autocomplate="off">
       </div> 
      <div class="inputfield">
          <label>ADRESSE</label>
          <input type="text" class="input" value="<?php echo $clientInfo["ADRESSE"];?>" name="adress" autocomplate="off">
       </div> 
      <div class="inputfield">
          <label>DELEVRER LE</label>
          <input type="date" name="delivredate" value="<?php echo $clientInfo["DELEVRER_LE"];?>" autocomplate="off" class="input">
       </div> 
       <div class="inputfield">
          <label>PERMIS</label>
          <input type="text" class="input" value="<?php echo $clientInfo["PERMIS"];?>" name="permis" autocomplate="off">
       </div> 
      <div class="inputfield">
        <input type="submit" value="Register" class="btn">
        <button class="btn exitEdit"></button>
      </div>
    </div>
 </form>
</div>
<!--  ================================================= -->
<div class="wrapper">
<form action="">
    <div class="title">
      AJOUTE VOITURE
    </div>
    <div class="form">
        <div class="field">
            <div class="inputfield">
            <label>MATRICULE</label>
            <input type="text" name="matricule" class="input" autocomplate="off">
            </div>  
            <div class="inputfield">
            <label>MARQUE</label>
            <div class="custom_select">
                <select name="couler" id="">
                        <option value="">Select</option>
                        <option value=""></option>
                </select>  
            </div>
            </div>  
            <div class="inputfield">
            <label>MODELE</label>
            <div class="custom_select">
                <select name="modele" id="">
                        <option value="">Select</option>
                        <option value=""></option>
                </select>  
            </div>       
            </div> 
            <div class="inputfield">
            <label>CARBURANT</label>
            <div class="custom_select">
                <select name="carburant" id="">
                        <option value="">Select</option>
                        <option value="Gaz Oil">Gaz Oil</option>
                        <option value="issence">issence</option>
                </select>  
            </div>              
            </div> 
            <div class="inputfield">
            <label>PRIX/HEURE</label>
            <input type="number" class="input" name="adress" autocomplate="off">
            </div> 
            <div class="inputfield">
            <label>PRIX/JOUR</label>
            <input type="number" class="input" name="adress" autocomplate="off">
            </div> 
            <div class="inputfield">
            <label>COULEUR</label>
            <div class="custom_select">
                <select name="couleur" id="">
                        <option value="">Select</option>
                        <option value=""></option>
                        <option value=""></option>
                </select>  
            </div>  
            </div> 
        </div>
       <div class="imagevield">
           
       </div>
       <div class="inputfield">
        <input type="submit" value="Register" class="btn">
       </div>
    </div>
 </form>
</div>