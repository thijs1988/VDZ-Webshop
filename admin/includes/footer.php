
      <footer class="text-center jumbotron" id="footer">&copy; Copyright 2016 VDZ Webshop</footer>
      <style>
      #footer{
        width: 50%;
        height: 60%;
        border: 2px solid #000;
        border-radius: 15px;
        box-shadow: 7px 7px 15px rgba(0,0,0,0.6);
        margin: 8% auto;
        padding: 15px;
        background-color:
      }
      </style>
      <script type="text/javascript">

      //function updatesizes in the button
      function updateSizes(){
      	var sizeString = '';
      	for (var i = 1; i <= 12; i++) {
      		if ($('#size'+i).val() != ''){
      			sizeString += $('#size'+i).val()+':'+$('#qty'+i).val()+':'+$('#threshold'+i).val()+',';
      		}
      	}
      	$('#sizes').val(sizeString);
      }

      //launch modal on click by calling this function
            function get_child_options(selected) {
                  if (typeof selected == 'undefined') {
                     var selected = '';
                  }

                  var parentId = $('#parent').val();
                  $.ajax({   //jQuery.ajax
                   url: '/ecommerce website/admin/parsers/child_categories.php',
                   type: 'POST',
                   data: {parentId : parentId, selected : selected},
                   success: function(data){
                      $('#child').html(data);
                   },
                   errors: function(){
                        alert('Something terribly went wrong with child option.')
                   },
            });
      }
      $('select[name="parent"]').change(function(){
            get_child_options();
      });

    </script>
      </body>
      </hetml>
