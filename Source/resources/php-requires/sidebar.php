                <div class="text-center mt-5">
                    <div class="alert alert-dark alert-dismissible text-center">
                        <button type="button" class="close info" data-dismiss="alert">&times;</button>
                        <span class="info">This site use cookies more in <a href="../pages/cookies_policy.php">Cookies Policy</a></span>
                    </div>

                    <div class="footer list-unstyled text-center">
                        <a href="https://github.com/danielmac03/Social-Network" target="_blank">Github</a>
                        <a href="../pages/cookies_policy.php">Cookies Policy</a>
                        <a href="../pages/terms_and_conditions.php">Terms and Conditions</a>
                    </div>
                </div><br>
            </main>

            <div class="col-lg-3 d-none d-xl-block d-lg-block">

                <h2>Trends</h2><hr>

                <?php

                    $stop_words = array(" ", "", ",", ".", "EL", "LA", "LOS", "LAS", "UN", "UNA", "DE", "Y", "A" , "THE", "\AND");

                    $trends = array();

                    $date = date_create(date("Y-m-d H:m:s"));
                    $date = date_modify($date, "-1 day");
                    $date = date_format($date, "Y-m-d H:m:s");

                    $entries = getEntriesByDate($db, $date);

                    if($entries):
                        while($entry = mysqli_fetch_assoc($entries)){
                            $entry = $entry['entry'];
                            $entry = strtolower($entry);
                            $words = explode(" ", $entry);

                            for($i = 0; $i <= count($words)-1; $i++){

                                $words[$i] = strtoupper($words[$i]);
                                $words[$i] = str_replace("!", "", $words[$i]);
                                $words[$i] = str_replace("?", "", $words[$i]);
                                $words[$i] = str_replace(".", "", $words[$i]);
                                $words[$i] = str_replace(",", "", $words[$i]);

                                $exist_stop_words = false;

                                for($x = 0; $x <= count($stop_words)-1; $x++){

                                    if($stop_words[$x] == $words[$i]){
                                        unset($words[$i]);
                                        $exist_stop_words = true;
                                        break;
                                    }

                                }

                                if($exist_stop_words == false){
                                    array_push($trends, $words[$i]);
                                }

                            }
                        }

                        $trends = array_count_values($trends);
                        arsort($trends);
                        $trends = array_slice($trends, 0, 5);
                        $trends = array_keys($trends);

                        for($i = 0; $i <= count($trends)-1; $i++):

                ?>

                <a href="../pages/searcher.php?search=<?=$trends[$i]?>" class="trends ml-4 d-block reduced mb-5">#<?=$trends[$i]?></a>

                    <?php endfor; ?>

                <?php endif; ?>

            </div>
        </div>

    <?php deleteErrors(); ?>

    </body>
</html>