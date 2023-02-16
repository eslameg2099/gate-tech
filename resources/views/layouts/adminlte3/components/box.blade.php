<div class="card card-gray card-outline {{ isset($collapsed) && $collapsed ? 'collapsed-card' : '' }}">
    @if(isset($title) || isset($tools))
        <div class="card-header">
            <h3 class="card-title m-0" style="cursor: pointer" data-card-widget="collapse">{{ $title ?? '' }}</h3>

            <div class="card-tools">
                {{ $tools ?? '' }}
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
    @endif

    <div class="card-body {{ $bodyClass ?? '' }}">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endisset
</div>
<!-- /.card -->

