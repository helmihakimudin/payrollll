<table>    
    <thead>        
    <tr>            
        <th align="center">ID</th>            
        <th align="center">USER ID</th>            
        <th align="center">NAMA</th>            
        <th align="center">EMAIL</th>
        <th align="center">TEMPAT LAHIR</th>
        <th align="center">TANGGAL LAHIR</th>
        <th align="center">JENIS KELAMIN</th>
        <th align="center">STATUS KARYAWAN</th>
        <th align="center">STATUS PERNIKAHAN</th>
        <th align="center">JUMLAH ANAK</th>
        <th align="center">NOMOR HANDPHONE</th>     
        <th align="center">NOMOR KTP</th>     
        <th align="center">NOMOR KK</th>
        <th align="center">ALAMAT KTP</th>                 
        <th align="center">ALAMAT</th>            
        <th align="center">PASSWORD</th>            
        <th align="center">CABANG</th>            
        <th align="center">DEPARTEMEN</th>            
        <th align="center">JABATAN</th>            
        <th align="center">TANGGAL BERGABUNG</th>   
        <th align="center">SAMPAI TANGGAL</th>   
        <th align="center">STATUS KONTRAK</th>            
        <th align="center">NAMA REKENING</th>            
        <th align="center">NOMOR REKENING</th>            
        <th align="center">NAMA BANK</th>                       
        <th align="center">NPWP</th>        
    </tr>    
    </thead>    
    <tbody>        
    @foreach ($data as $row)        
    @php 
        $branch = DB::table('branches')->select('name as branch_name')->where('id','=',$row['branch_id'])->first();            
        $departements = DB::table('departments')->select('name as departement_name')->where('id','=',$row['department_id'])->first();            
        $designation = DB::table('designations')->select('name as designations_name')->where('id','=',$row['designation_id'])->first();        
    @endphp 
        <tr>            
            <td align="center">{{ $row['id'] }}</td>            
            <td align="center">{{ $row['user_id'] }}</td>            
            <td align="center">{{ $row['name'] }}</td>            
            <td align="center">{{ $row['email'] }}</td> 
            <td align="center">{{ $row['pob'] }}</td>              
            <td align="center">{{ $row['dob'] }}</td>            
            <td align="center">{{ $row['gender'] }}</td>
            <td align="center">{{ $row['employee_status']}}</td>
            <td align="center">{{ $row['merriage_status']}}</td>
            <td align="center">{{ $row['number_children']}}</td>        
            <td align="center">{{ $row['phone'] }}</td>  
            <td align="center">{{ $row['id_card'] }}</td>
            <td align="center">{{ $row['family_card'] }}</td>
            <td align="center">{{ $row['id_card_address'] }}</td>                
            <td align="center">{{ $row['address'] }}</td>            
            <td align="center">{{ $row['password'] }}</td>            
            <td align="center">@if(!empty($branch->branch_name)) {{ $branch->branch_name }} @else {{"-"}} @endif</td>            
            <td align="center">@if(!empty($departements->departement_name)) {{ $departements->departement_name }} @else {{"-"}} @endif</td>            
            <td align="center">@if(!empty($designation->designations_name)) {{ $designation->designations_name }} @else {{"-"}} @endif</td>            
            <td align="center">{{ $row['company_doj'] }}</td>
            <td align="center">{{ $row['end_date'] }}</td>
            <td align="center">{{ $row['contract_status']}}</td>            
            <td align="center">{{ $row['account_holder_name'] }}</td>            
            <td align="center">{{ $row['account_number'] }}</td>            
            <td align="center">{{ $row['bank_name'] }}</td>                    
            <td align="center">{{ $row['tax_payer_id'] }}</td>        
        </tr>        
        @endforeach    
    </tbody>
</table>