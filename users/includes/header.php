 <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="index.html" class="logo"><b>MediCare</b></a>
                
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout.php">Logout</a></li>
                    <script>
$(document).ready(function(){

function loadNotifications(){
    $.ajax({
        url: "fetch_notifications.php",
        method: "POST",
        success:function(data){
            let res = JSON.parse(data);
            $("#notif-count").text(res.count);
            $("#notif-content").html(res.html);
        }
    });
}

loadNotifications();
setInterval(loadNotifications, 10000);

});
</script>
            	</ul>
            </div>
        </header>