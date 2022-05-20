<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'GA community')
            <img src="https://gomed-by-sayna.fra1.digitaloceanspaces.com/gacom_logo.png" class="logo" alt="GA Logo"
                width="250" height="250">
            @else
            {{ $slot }}
            @endif
        </a>
    </td>
</tr>