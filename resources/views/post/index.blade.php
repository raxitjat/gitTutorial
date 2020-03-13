@extends('layouts.default')
@section('content')

<div class="container">
    <h2>Laravel DataTables Task (yajara)</h2>


    <a href="{{route('post.create')}}" class="btn btn-success float-right">Add New Post</a><br><br>

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
@endsection
@push('js')

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
               ajax: '{{ url('post/dataTable') }}',
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
                    
                    var deleteData='<a class="btn btn-danger delete ml-1" href="{{route('post.destroy',':id')}}" ><i class="fa fa-trash" aria-hidden="true"></i></a><br/>'; 
                    // var mailData= '<a class="btn btn-warning  ml-1" href="{{route('post.edit',':id')}}"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>';

                    deleteData = deleteData.replace(':id', id);
                    editData = editData.replace(':id', id);
                    // mailData = mailData.replace(':id', id);
                    
                    
                    return editData +deleteData; 
                },
                orderable: false,
                searchable: false,
                width:'10%'
             },
            

                     ]
            });
         });
         $('#table').on('click', '.delete', function (e) { 
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",

                }
            }); 
            var url = $(this).attr('href');
            // confirm then
            $.ajax({
                url: url,
                type: 'DELETE'
                // dataType: 'json'
                // data: {method: '_DELETE', submit: true}
            }).always(function (data) {
                $('#table').DataTable().draw(false);
            });
        });

</script>
@endpush