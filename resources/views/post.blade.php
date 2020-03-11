<html lang="en">

<head>
    <title>Laravel DataTables Tutorial Example</title>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>



</head>

<body>
    <div class="container">
        <h2>Laravel DataTables Tutorial Example</h2>
        <table class="table table-striped table-bordered" id="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Created_at</th>
                    <th>Updated_at</th>
                    <th>Edit</th>
                    {{-- <th>Delete</th> --}}

                </tr>
            </thead>
        </table>
    </div>
    <script>
        $(function() {
               $('#table').DataTable({
               processing: true,
               serverSide: true,
               lengthMenu: [
                    [ 10, 20, 30, -1 ],
                    [ '10 rows', '20 rows', '30 rows', 'Show all' ]
                ],
               method:'POST',
               ajax: '{{ url('post') }}',
               columns: [
                        { data: 'id',width:'5%' },
                        { data: 'title',width:'10%' },
                        { data: 'description',width:'25%' },
                        { data: 'created_at',width:'10%' },
                        { data: 'updated_at',width:'10%'},
                        { data: null,
                render: function (dataField) { 
                    // console.log(dataField);
                    var id = dataField.id;
                    // alert(idData);
                    var editData= '<a class="btn btn-info ml-1" href="{{route('post.edit',':id')}}"><i class="fa fa-edit"></i></a>';
                    var deleteData='<a class="btn btn-danger ml-1" href="{{route('post.destroy',':id')}}" ><i class="fa fa-trash" aria-hidden="true"></i></a><br/><br/>'; 
                    var mailData= '<a class="btn btn-warning ml-1" href="{{route('post.edit',':id')}}"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>';

                    deleteData = deleteData.replace(':id', id);
                    editData = editData.replace(':id', id);
                    mailData = mailData.replace(':id', id);
                    
                    
                    return editData +deleteData+mailData; 
                },
                orderable: false,
                searchable: false,
                width:'10%'
             },
            
                        
                     ]
            });
         });
    </script>
</body>

</html>