
<div class="panel panel-right panel-right panel-cover panel-resizable panel-init">
  <div class="block">
    <img src="/img/WeCapacitate.png" width="200">
    <p><a class="panel-close" href="#">x</a></p>
  </div>
</div>

  
    <div class="navbar">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
       <div class="left">
        <a class="link panel-open " data-panel=".panel-right">
          <i class="icons f7-icons maroon">menu</i>
        </a>
        
      </div>
        <div><img src="/img/logo.png" height="50"></div>
        <div class="title Raleway sliding"><strong><span class="maroon">We</span><span class="gray">C</span><span class="maroon">apacitate</span></strong> - <small>Alone, we are nothing. Together <span class="maroon">We</span><span class="gray">C</span><span class="maroon">apacitate</span></small></div>
       <div class="right Raleway" id="WhichMenu">
       
       </div>
      </div>
    </div>


<div class="login-screen">
    <div class="view">
      <div class="page">
        <div class="page-content login-screen-content">
          <div class="login-screen-title"><img src="/img/WeCapacitate.png" width="200"><br>
          <div class="title Raleway sliding"><small>Alone, we are nothing. Together <span class="maroon">We</span><span class="gray">C</span><span class="maroon">apacitate</span></small></div></div>
          <form  id="join" >
            <div class="list">
              <ul>
      <li id="mcaNumberDiv">
        <div class="item-content item-input">
          <div class="item-inner">
            <div class="item-title item-label">MCA Number</div>
            <div class="item-input-wrap">
              <input type="number" name="mcaNumber" id="mcaNumber" placeholder="MCA Number" required validate pattern="[0-9]*" data-error-message="Only numbers please!" max="99999999" min="10000000">
            </div>
          </div>
        </div>
      </li>
                
              </ul>
            </div>
            <div class="list">
              <ul>
                <li><a class="list-button" href="#" onclick="return searchmca();">Sign In</a></li>
              </ul>
              <div class="block-footer">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p><a class="link login-screen-close" href="#">Close Login Screen</a></p>
              </div>
            </div>
          </form>
          <form class="list" id="claim">
     <div id="MCAFound">
     </div>
    </form>
        </div>
      </div>
    </div>
    
  </div>

<script>
 
 if (localStorage[storage + ".mcaNumber"]) {
  var mcaNumber = localStorage[storage + ".mcaNumber"];
  console.log("mcaNumber");
  var whichmenu = '<a href="/wecap/dashboard/'+mcaNumber+'/" class="link Share external"  >'+mcaNumber+'</a>';
 }else{
  console.log("mcaNumber not found");
  var whichmenu = '<a href="#" class="link Share login-screen-open" data-login-screen=".login-screen" >Login</a>';
 }
 $$("#WhichMenu").html(whichmenu);
 
</script>