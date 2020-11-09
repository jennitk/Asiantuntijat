<?php

// Include config file
require_once "config.php";

//Connect database
$dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $db = "rtp_db";
 $port="3307";

 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db,$port) or die("Connect failed: %s\n". $conn -> error);

//valitaan taulu, haetaan data
$sql = "SELECT users_fk, tp_etunimi, tp_sukunimi, tp_paikkakunta, tp_esittelyteksti FROM terapeutit";
 $result = $conn->query($sql);
 $terapeutit= mysqli_fetch_all($result, MYSQLI_ASSOC);

 mysqli_free_result($result);

//Sulje yhteys 

?>


<?php include('includes/head.php') ?> 
<body>

    <div class="jumbotron" >
        <div class="container">
        <!-- sivun esittely --> 
        <section style="margin-top: 50px;">
            <div class="center">
                <div>
                    <h1 class="fontti">Tutustu terapeutteihimme</h1>
                    <br>
                    <h4 class="fonttiLI" style="font-weight: lighter;">Palvelumme asiantuntevat ja laillistetut ravitsemusterapeutit ovat aina valmiita auttamaan juuri sinun tarpeitasi.</h4>
                </div>
            </div>
        </section>

        <br>

        <div style="padding-top: 60px"><p><a class="btn btn-info btn-lg" href="hakusivu2_AMANDA.php" role="button">Hae terapeutteja suodattimien perusteella &raquo;</a></p>
        </div>

            <!-- container, kortit -->
            <div class="container">
                <div class="row">

                <!-- PHP, haetaan tiedot terapeutit taulusta -->
                <?php foreach ($terapeutit as $terapeutti) { ?>


                    <!--column-->
                    <div class="card-columns col-md-4 col-sm-12 col-xs-12" style="padding:5%;">

                        <!-- card -->
                        <div class="card card-inverse card-primary h-100 text-center" style="min-width: 350px; width: 100%; min-height: 650px; max-height:650px;">

                        <?php 
                        //kuvan hakeminen uploadedimage taulusta
                        $id=$terapeutti['users_fk'];


                        $kuva = "SELECT users_fk, imagename FROM uploadedimage WHERE users_fk='$id'";
                        $tulos = $conn->query($kuva);
                        $kuvat= mysqli_fetch_all($tulos, MYSQLI_ASSOC);

                        mysqli_free_result($tulos);
                        foreach ($kuvat as $kuva){
                        $imgname = ($kuva['imagename']);
                        }
                        $folder='ladatutkuvat/'
                        ?>

                        <!-- kuva -->
                        <img class="card-img-top" style="width: 350px; height: 350px; background-repeat: no-repeat; " src="<?php echo $folder.$imgname?>">

                            <div class="row">
                            <!--card-body -->
                                <div class="card-body center">

                                <!-- nimi -->
                                <h3 class="card-title fonttiB">

                                <?php
                                echo htmlspecialchars($terapeutti['tp_etunimi']) ?>
                                
                                <?php echo htmlspecialchars($terapeutti['tp_sukunimi']) ?>
                                </h3>

                                <!--  paikkakunta -->
                                <h4 class="card-title fontti" style="font-size: 23px">
                                <?php echo htmlspecialchars($terapeutti['tp_paikkakunta']) ?>
                                </h4>

                                    <!--esittelyteksti -->
                                    <div class="container" style="width: 320px; height: 150px;"> 

                                    <div style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 5; -webkit-box-orient: vertical;">  

                                    <h5 class="card-text fontti">
                                    <?php echo htmlspecialchars($terapeutti['tp_esittelyteksti']); ?>
                                    </h5>

                                    <!--webkitbox --> 
                                    </div>    

                                    <p class="card-text" style="color: white;">
                                    <?php
                                    $teksti=$terapeutti['tp_esittelyteksti'];
                                    $x=strlen($teksti);
                                    $j=250-$x;
                                    for($i=0; $i<$j; $i++){
                                    echo ".";
                                    } ?>
                                    </p>
                                    
                                    <!--container -->        
                                    </div>                      

                                <!--ajanvaraus -->

                                <a href="varaa_aika.php?id=<?php echo $terapeutti['users_fk']?>" style="min-width: 110px; max-width:100%; "  class="btn btn-info sticky-bottom">Ajanvaraus</a> 
                                                        

                                <!-- row-->
                                </div> 
                            <!--card-body -->
                            </div>
                        <!--card -->
                        </div>
                    <!--column -->
                    </div>

                <?php  } ?>

                <!--row -->
                </div>
            <!--container -->
            </div>
        <!--container -->
        </div>
    <!--jumbotron -->
    </div>

    <!--footer -->

    <?php include('includes/footer.php') ?> 

    <?php $conn->close(); ?>
</body>
</html>