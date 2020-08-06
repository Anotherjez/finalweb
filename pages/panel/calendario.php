<?php

include('../../libs/panelutils.php');

Connection::testconnection();

include_once('../../libs/user.php');
include_once('../../libs/user_session.php');

$userSession = new UserSession();
$user = new User();

if(isset($_SESSION['user'])){
    $user->setUser($userSession->getCurrentUser());
  }else if(isset($_POST['username']) && isset($_POST['password'])){
      
    $userForm = $_POST['username'];
    $passForm = $_POST['password'];
  
    if ($user->userExists($userForm, $passForm)) {
      $userSession->setCurrentUser($userForm);
      $user->setUser($userForm);
      header("Location: ../index.php");
    }else{
      echo '<script language="javascript">';
      echo "alert('Nombre de usuario y/o password incorrectos');";
      echo '</script>';
    }
  
  }else{
    header("Location: ../login.php");
}

$sql = "SELECT id, title, start, end, color FROM events";
$events = Connection::query_arr($sql);

include('headerpanel.php');

?>

<div class="container">
  <h2>Citas</h2>
  <div class="row">
        <div class="col-lg-12 text-center">
            <h1>FullCalendar PHP MySQL</h1>
            <p class="lead">Completa con rutas de archivo predefinidas que no tendrás que cambiar!</p>
            <div id="calendar" class="col-centered">
            </div>
        </div>        
    </div>
</div>
<script src="../../assets/js/main.min.js"></script>
<script src="../../assets/js/locales/es.js"></script>

<script>
 
 $(document).ready(function() {

     var date = new Date();
    var yyyy = date.getFullYear().toString();
    var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
    var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();
     
     $('#calendar').fullCalendar({
         header: {
              language: 'es',
             left: 'prev,next today',
             center: 'title',
             right: 'month,basicWeek,basicDay',

         },
         defaultDate: yyyy+"-"+mm+"-"+dd,
         editable: true,
         eventLimit: true, // allow "more" link when too many events
         selectable: true,
         selectHelper: true,
         
         events: [
         <?php foreach($events as $event): 
         
             $start = explode(" ", $event['start']);
             $end = explode(" ", $event['end']);
             if($start[1] == '00:00:00'){
                 $start = $start[0];
             }else{
                 $start = $event['start'];
             }
             if($end[1] == '00:00:00'){
                 $end = $end[0];
             }else{
                 $end = $event['end'];
             }
         ?>
             {
                 id: '<?php echo $event['id']; ?>',
                 title: '<?php echo $event['title']; ?>',
                 start: '<?php echo $start; ?>',
                 end: '<?php echo $end; ?>',
                 color: '<?php echo $event['color']; ?>',
             },
         <?php endforeach; ?>
         ]
     });     
     
 });

</script>
<?php include('../footer.php'); ?>