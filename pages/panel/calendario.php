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
  <div class="row">
        <div class="col-lg-12 text-center">
            <h1>Citas</h1>
            <div id="calendar" class="col-centered">
            </div>
        </div>        
    </div>
</div>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="ModalBody">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="../../assets/js/main.min.js"></script>
<script src="../../assets/js/locales/es.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: false,
        selectable: true,
        eventClick: function(info) {
            // Titulo
            document.getElementById('ModalLabel').innerHTML = info['event']['_def']['title'];
            // Body
            document.getElementById('ModalBody').innerHTML = "<strong>Fecha de inicio:</strong> " + info['event']['_instance']['range']['start'] + "<br>" + "<strong>Fecha de fin:</strong> " + info['event']['_instance']['range']['end'];
            $('#Modal').modal({
                show: true
            })
        },
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
    calendar.render();
});
 
</script>
<?php include('../footer.php'); ?>