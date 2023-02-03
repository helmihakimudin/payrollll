<html>
<head>
    <title>Signature</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>

    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">

    <style>
        .kbw-signature {
            width: 100%;
            min-height: 350px;
        }
        #sig canvas{
            width: 100%  !important;
            height: auto;
            border: 1px black solid;
        }

        .modal-dialog{
            max-width: 60%  !important;
        }
        .card-body {
            padding: 0;
        }

        @media (min-width: 250px) and (max-width: 820px) {
            .modal-dialog
            {
                max-width: 100%  !important;
            }

            .kbw-signature {
                width: 100%;
                /* min-height: 80vh !important; */
            }
            #sig canvas{
                width: 100% ;
                height: auto;
            }


        }
    </style>

</head>
<body class="bg-dark">
<div class="container">
   <div class="row">
       <div class="col-md-6 offset-md-3 mt-5">
           <div class="card">
               <div class="card-header">
                   <h5>Sign Contract </h5>
               </div>
               <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success  alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('signature.upload') }}">
                        @csrf
                        <div class="col-md-12">
                            <label class="" for="">Signature here:</label>
                            <br/>
                            <div id="sig" ></div>
                            <br/>
                            <button id="clear" class="btn btn-warning btn-sm mt-4">Clear Signature</button>
                            <textarea id="signature64" name="signed" style="display: none"></textarea>
                            <button class="btn btn-success btn-sm mt-4">Save</button>
                        </div>
                        <br/>

                    </form>
               </div>
           </div>
       </div>
   </div>
</div>
<script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>
</body>
</html>
