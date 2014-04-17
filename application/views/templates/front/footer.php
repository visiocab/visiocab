<div id="pre-footer">
  <div class="container">
  <div class="row">
    <div class="col-md-5">
      <h4>About</h4>
      <p>
        Visiocab software is built for educators, and provides an immursive experience for students to learn by doing.
      </p>
      <p>
      <a href="#" data-toggle="modal" data-target="#support" target="_self" class="btn btn-default"><b>Questions?</b> Let us know here!</a>
      </p>
    </div>
    <div class="col-md-7">
      <h4>Newsletter</h4>
      <p>
        We are always in beta. Get the latest updates on features, community, and developer access.
      </p>
      <form action="http://visiocab.createsend.com/t/d/s/maik/" method="post">
        <div class="row">
          <div class="col-sm-5">
            <div class="form-group">
              <label for="fieldName">Name</label>
              <input id="fieldName" name="cm-name" type="text" placeholder="First Last" class="form-control" />
            </div>
          </div>
          <div class="col-sm-7">
            <div class="form-group">
              <label for="fieldEmail">Email</label>
              <div class="input-group">
                <input id="fieldEmail" name="cm-maik-maik" type="email" placeholder="email@domain.com" class="form-control" required>
                  <span class="input-group-btn">
                    <button class="btn btn-success" type="submit">Sign Up</button>
                  </span>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  </div>
  </div>
</div>

<div id="footer">
<div class="container">
<div class="row">
  <div class="col-md-12">
    <div class="logo-footer">
      <a href="/" target="_self"><img src="img/visiocab.png" alt="Visiocab"></a>
    </div>
  </div>
  <div class="col-md-12">
    <p class="muted credit">Visiocab by <a href="http://vvicrew.com/" title="(vvi)" alt="Vision Video Interactive" target="_blank">Vision Video Interactive</a> is licensed under a <a href="http://creativecommons.org/licenses/by/4.0/" title="CC License" target="_blank">Creative Commons Attribution 4.0 International License</a>. &nbsp; <a class="disclaimer" href="/disclaimer">&#10059; Disclaimer</a></p>
  </div>
</div>
</div>
</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="js/bootstrap.min.js"></script>

<script>
  //doesn't block the load event
  function createIframe() {
      var i = document.createElement("iframe");
      i.src = "http://visiocab.com/display/115";
      i.scrolling = "auto";
      i.frameborder = "0";
      i.width = "100%";
      i.height = "430px";
      document.getElementById("frameContainer").appendChild(i);
  };
  // Check for browser support of event handling capability
  if (window.addEventListener) window.addEventListener("load", createIframe, false);
  else if (window.attachEvent) window.attachEvent("onload", createIframe);
  else window.onload = createIframe;
</script>

<script>
// header menu toggles
$('.dropdowns').find('article').hide();
$('#loginnav a').click(function(e){
  e.preventDefault();
  var page = $(this).text().toLowerCase();
  $('.dropdowns').find('article').slideUp(400);
  $('[class="'+page+'_page"]').slideDown(300);
});
$('article').mouseleave(function() {
  $(this).slideUp('3000');
});
</script>

<!-- Google Analytics -->
<script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47558283-1', 'visiocab.com');
  ga('send', 'pageview');

</script>


</body>
</html>
