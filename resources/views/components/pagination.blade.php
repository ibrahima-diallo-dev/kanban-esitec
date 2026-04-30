@if ($paginator->hasPages())
<nav style="display:flex;align-items:center;justify-content:center;gap:4px;margin-top:2rem;">

    {{-- Bouton Précédent --}}
    @if ($paginator->onFirstPage())
        <span style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:9px;border:1px solid #e8e9f2;background:#f9f9fc;color:#c8c9d8;cursor:not-allowed;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:9px;border:1px solid #e8e9f2;background:#fff;color:#6b6d8a;text-decoration:none;transition:.15s;"
           onmouseover="this.style.borderColor='#4f6ef7';this.style.color='#4f6ef7'"
           onmouseout="this.style.borderColor='#e8e9f2';this.style.color='#6b6d8a'">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </a>
    @endif

    {{-- Numéros de pages --}}
    @foreach ($elements as $element)

        {{-- Séparateur "..." --}}
        @if (is_string($element))
            <span style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;font-size:13px;color:#6b6d8a;">
                {{ $element }}
            </span>
        @endif

        {{-- Pages --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    {{-- Page active --}}
                    <span style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:9px;background:#4f6ef7;color:#fff;font-size:13px;font-weight:700;border:1px solid #4f6ef7;">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}"
                       style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:9px;border:1px solid #e8e9f2;background:#fff;color:#6b6d8a;font-size:13px;font-weight:500;text-decoration:none;transition:.15s;"
                       onmouseover="this.style.borderColor='#4f6ef7';this.style.color='#4f6ef7'"
                       onmouseout="this.style.borderColor='#e8e9f2';this.style.color='#6b6d8a'">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        @endif

    @endforeach

    {{-- Bouton Suivant --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:9px;border:1px solid #e8e9f2;background:#fff;color:#6b6d8a;text-decoration:none;transition:.15s;"
           onmouseover="this.style.borderColor='#4f6ef7';this.style.color='#4f6ef7'"
           onmouseout="this.style.borderColor='#e8e9f2';this.style.color='#6b6d8a'">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    @else
        <span style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:9px;border:1px solid #e8e9f2;background:#f9f9fc;color:#c8c9d8;cursor:not-allowed;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </span>
    @endif

</nav>

{{-- Résumé --}}
<p style="text-align:center;font-size:12px;color:#6b6d8a;margin-top:10px;">
    Affichage de {{ $paginator->firstItem() }} à {{ $paginator->lastItem() }}
    sur {{ $paginator->total() }} résultats
</p>
@endif
