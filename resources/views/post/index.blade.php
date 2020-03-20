@extends('layouts.default')
@section('content')

<div class="container">

    <h2>Laravel DataTables Task (yajara)</h2>

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
            @php
                Session::forget('success');
            @endphp
        </div>
        @endif
    <a href="{{route('post.create')}}" class="btn btn-success float-right">Add New Post</a><br><br>

    <table class="table table-striped table-bordered" id="table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Created_at</th>
                <th>Updated_at</th>
                <th>Refrence</th>
                <th>Edit</th>
                {{-- <th>Delete</th> --}}

            </tr>
        </thead>
    </table>
</div>
@endsection
@push('js')

<script>
    $(document).ready(function () {
               var postData=$('#table').DataTable({
               processing: true,
            //    responsive: true,
               serverSide: true,
               lengthMenu: [
                    [ 10, 20, 30, -1 ],
                    [ '10 rows', '20 rows', '30 rows', 'Show all' ]
                ],
                dom: '<"html5buttons"B>lTfgitp',
                ajax: {
                    url: '{!! route('postDatatable') !!}',
                    type: 'GET',
                },
            //    method:'GET',
            
               columns: [
                        { data: 'id',width:'5%' },
                        {
                            data:null,
                            render:function(dataField){
                                console.log(dataField.image_path);
                                return "<a href='"+ dataField.image_path +"' target='_blank'><img src='"+dataField.image_path+"' class='img-thumbnail medium-image'></a>";
                            },
                            orderable:false,
                            searchable: false,
                            width: '15%',
                            //className: 'text-center'
                        },
                        { data: 'title',width:'10%' },
                        { data: 'description',width:'25%' },
                        { data: 'created_at',width:'10%' },
                        { data: 'updated_at',width:'10%'},
                        { data: 'refrence',width:'10%'},
                        { data: null,
                            render: function (dataField) { 
                                var id = dataField.id;
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
    
         $('#table').on('click', '.delete', function (e) { 
            e.preventDefault();
            var url = $(this).attr('href');
            alert(url);
            // confirm then
            $.ajax({
                url: url,
                type: "POST",
                headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                data:{
                    _method:"DELETE"
                },
            }).always(function (data) {
                $('#table').DataTable().draw(false);
            });
        });
    });
    


// @if(Session::has('success'))
//         toastr.success("{{ Session::get('success') }}");
// @endif


// @if(Session::has('info'))
//         toastr.info("{{ Session::get('info') }}");
// @endif


// @if(Session::has('warning'))
//         toastr.warning("{{ Session::get('warning') }}");
// @endif


// @if(Session::has('error'))
//         toastr.error("{{ Session::get('error') }}");
// @endif



</script>
@endpush