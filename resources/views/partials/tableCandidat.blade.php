@foreach($candidats as $c)
    <tr>
        <td class="text-xs font-weight-bold">{{ $c->nom }}</td>
        <td class="text-xs font-weight-bold">{{ $c->numero_telephone }}</td>
        <td class="text-xs font-weight-bold">{{ $c->profession }}</td>
        <td class="text-xs font-weight-bold text-center">{{ $c->created_at->format('Y-m-d') }}</td>
        <td class="text-center">
            </td>
    </tr>
@endforeach
