<div id="Head" class="bg-danger text-light text-center">
    <strong>
        <pre style="font-size:15px;">
  <ion-icon name="mail"></ion-icon> Azeemaj101@gmail.com   <ion-icon name="phone-portrait"></ion-icon> 03244064060
  </pre>
    </strong>
</div>
<?php
$sql1 = "SELECT `ISSUE` FROM `a_issues`";
$result1 = mysqli_query($Connect_DB, $sql1);
$num = 0;
$form = 0;
$err = "";
echo '<marquee behavior="scroll" direction="left" scrollamount="12" class="bg-danger text-light _marquee" onmouseover="this.stop();" onmouseout="this.start();"><strong style="font-size:18px;">Donate on <img src="/reddrop/pictures/7.png" alt="..." style="height:25px; width: 150px;">:03244064060&nbsp&nbsp&nbsp';
if ($result1) {
    while ($row = mysqli_fetch_assoc($result1)) {
        $form += 1;
        $form;
        echo "<span class='text-dark'>Case". $form .":</span> ".$row['ISSUE']." ";
    }
}
echo '</strong></marquee>';
?>