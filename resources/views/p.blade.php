<table id="laravel-datatable-crud" class="table table-striped table-bordered dt-responsive" style="width:100%">
    <thead>
        <tr>
            <th>title</th>
            <th>price</th>
            <th >catego id</th>
            
        </tr>
    </thead>
    @foreach ($all as $a)
    <tbody>    
    <tr>
           
        
        <td>{{$a->title}}</td>
        <td>{{$a->price}}</td>
        <td>{{$a->category->Name}}</td>
        
    </tr>
</tbody>
    @endforeach
</table>