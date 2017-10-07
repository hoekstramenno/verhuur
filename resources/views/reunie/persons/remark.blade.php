

    <div id="reply-{{ $remark->id }}" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    {{ $remark->created_at->diffForHumans() }} ...
                </h5>
                {{--@if (Auth::check())--}}
                    {{--<div>--}}
                        {{--<favorite :reply="{{ $remark }}"></favorite>--}}
                    {{--</div>--}}
                {{--@endif--}}
            </div>
        </div>
        <div class="panel-body">
            <article>
                <div>{{ $remark->remark }}</div>
            </article>
        </div>
    </div>
