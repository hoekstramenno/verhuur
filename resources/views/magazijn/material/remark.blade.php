<div id="reply-{{ $remark->id }}" class="card">
    <header class="card-header">
        <p class="card-header-title">
            {{ $remark->title }}
        </p>
        <a href="#" class="card-header-icon" aria-label="more options">
      <span class="icon">
        <i class="fa fa-angle-down" aria-hidden="true"></i>
      </span>
        </a>
    </header>
    <div class="card-content">
        <div class="content">
            <p>
                {{ $remark->remark }}
            </p>
            <small>{{ $remark->owner->name }}
                posted
                {{ $remark->created_at->diffForHumans() }} ...
            </small>
            <br/>
            <small>Last updated: {{ $remark->updated_at }}</small>


        </div>
    </div>
    @can('update', $remark)
        <footer class="card-footer">
            <a href="#" class="card-footer-item">Save</a>
            <a href="#" class="card-footer-item">Edit</a>
            <a href="#" class="card-footer-item">Delete</a>
        </footer>
    @endcan
</div>
