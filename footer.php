<footer class="footer-distributed">
    <div class="footer-right">
        <a href="#"><span class="mdi mdi-facebook"></span></a>
        <a href="#"><span class="mdi mdi-twitter"></span></a>
        <a href="#"><span class="mdi mdi-linkedin"></span></a>
        <a href="#"><span class="mdi mdi-instagram"></span></a>
    </div>
    <div class="footer-left">
        <p class="footer-links">
            <span class="mdi mdi-facebook-box"></span>
            <a class="link-1" href="#">Home </a>
            <a href="#">Feed</a> 
            <a href="#">About</a> 
            <a href="#">Faq</a> 
            <a href="#">Contact</a>
        </p>
        <p>Febina Community &copy; 2021</p>
    </div>
</footer> <!-- BOOTSTRAP  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<!-- JQUERY  -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous"></script>
<script src="/Febina/Members-Portal/assets/js/script.js"></script>
<!-- AOS  -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('postbody', {
        removePlugins: 'uploadimage,tabletools,tableselection,table,save,pastefromgdocs,pastefromlibreoffice,pastefromword,removeformat,copyformatting,clipboard,image,newpage,preview,scayt,forms,blockquote,div,language,flash,smiley,pagebreak,iframe'
    });
</script>

<script>
    $(document).ready(function() {
        AOS.init();
    });
</script>

<!-- DATA TABLES -->
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
<script>
    $(document).ready(function() {
        $('#myTable').DataTable(
            {
                "info" : false,
                "lengthChange" : false
            }
        );
    });
    $(document).ready(function() {
        $('#myTable1').DataTable(
            {
                "info" : false,
                "lengthChange" : false
            }
        );
    });
    $(document).ready(function() {
        $('#myTable2').DataTable(
            {
                "info" : false,
                "lengthChange" : false
            }
        );
    });
    $(document).ready(function() {
        $('#myTable3').DataTable(
            {
                "info" : false,
                "lengthChange" : false
            }
        );
    });
</script>
<script>
        $(document).ready(function()
        {
            var flag = 0;
            $.ajax({
                type:"POST",
                url:"infinitescrollfeed.php",
                data:{
                    'offset':flag,
                    'limit':3
                },
                success:function(data){
                    $('#posts').append(data);
                    flag = flag+3;
                }
            });

            $(window).scroll(function()
            {
                if($(window).scrollTop() >= $(document).height() - $(window).height())
                {
                    $.ajax({
                    type:"POST",
                    url:"infinitescrollfeed.php",
                    data:{
                        'offset':flag,
                        'limit':3
                    },
                    success:function(data){
                        $('#posts').append(data);
                        flag = flag+3;
                    }
                });
            }
            });
        });
        function Like(q,p)
        {
            id = q.replace('like','');
            console.log(id);
            console.log(p.name);
            if (document.getElementById(id).className == "fa fa-thumbs-o-up fa-2x")
            {
                document.getElementById(id).className = "fa fa-thumbs-up fa-2x";
                $.ajax({
                type:"POST",
                url:"http://localhost/Febina/Members-Portal/code.php",
                data:{
                    'likedby':p.name,
                    'postid':id,
                },
                success:function(data){
                    location.reload();
                }
            });
            }
            else
            {
                document.getElementById(id).className = "fa fa-thumbs-o-up fa-2x";
                $.ajax({
                type:"POST",
                url:"http://localhost/Febina/Members-Portal/code.php",
                data:{
                    'unlikedby':p.name,
                    'postid':id,
                },
                success:function(data){
                    location.reload();
                }
            });
            }
        }
    </script>
</body>

</html>