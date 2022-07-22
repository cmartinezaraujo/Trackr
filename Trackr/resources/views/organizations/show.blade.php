@extends('layout')
@section('content')

<header class="navbar">
  <section class="navbar-section">

  </section>

  <section class="navbar-center">
    <h1>{{$Organization->organization_name}}</h1>
  </section>

  <section class="navbar-section">
    <div class="popover popover-bottom">
      <span class="badge" data-badge="{{$Notifications->count()}}">
        <a href="{{ route('user-notification-center', $Organization->owner->id) }}" method="GET">Notifications</a>
      </span>
      <div class="popover-container">
        @foreach ($Organization->owner->unreadNotifications as $notification)
        <div class="card">
          <div class="card-header">
            Notification
          </div>
          <div class="card-body">
            <p>Notification from: {{$notification->data['sender']}}</p>
            <p>Message: {{$notification->data['message']}}</p>
          </div>
          <div class="card-footer">
            {{$notification->created_at}}
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button class="btn btn-link" :href="route('logout')" onclick="event.preventDefault();
                        this.closest('form').submit();">
          {{ __('Log Out') }}
        </button>
      </form>
    </div>
  </section>

</header>

<section class="body-section bg-secondary">
  <h2 class="center-header">Your Organization Overview</h2>
  <div class="organization-overview-container">
    <div class="organization-information">
      <h3 class="center-header">Activity Center</h3>
      <p>There are currently {{$Members->count()}} members in your organization.</p>
      <p>Your organization members have made a total of {{$ReportCount}} reports.</p>
      <p>There are currently {{$Organization->networks->count()}} active sub-networks within your organization.</p>
      <a class="btn btn-primary" href="{{route('show-organization-graphs', $Organization->organization_id)}}">View
        Reports Activity</a>
    </div>
    <div class="organization-message-center">
      <h3 class="center-header">Message Center</h3>
      <form class="form-group" method="POST"
        action="{{route('organization-send-message', $Organization->organization_id)}}">
        <label class="form-label" for="message">This message will be sent to all active members of
          your organization</label>
        @csrf
        <textarea class="form-input" id="message" placeholder="Message" rows="3" name="message"></textarea>
        <button type="submit" class="btn btn-primary">Send Message</button>
      </form>
    </div>
  </div>
</section>

<section class="body-section bg-dark">
  <h2>Members</h2>

  <div id="member-section-container">
    <div class="organization-member-container">
      <h6>Active Members</h6>
      @if($activeMembers->count() > 0)
      @foreach ($activeMembers as $member)
      <div class="organization-member-card bg-secondary">

        <figure class="avatar avatar-lg"
          data-initial="{{substr($member->user->first_name,0,1)}}{{substr($member->user->last_name,0,1)}}"
          style="background-color: #5755d9;">
          @if ($member->user->status == 'healthy')
          <i class="avatar-presence online"></i>
          @elseif ($member->user->status == 'quarantine')
          <i class="avatar-presence away"></i>
          @else
          <i class="avatar-presence busy"></i>
          @endif
        </figure>

        <div class="org-member-info-card">
          {{-- <div class="card-title h5">{{$member->user->first_name}} {{$member->user->last_name}}</div>
          <div class="card-subtitle text-gray">{{$member->user->last_login}}</div> --}}
          <p class="text-dark">{{$member->user->first_name}} {{$member->user->last_name}}</p>
          <a class="card-subtitle text-primary" href="mailto:{{$member->user->email}}">{{$member->user->email}}</a>
          {{-- <p>Status: {{$member->user->status}}</p> --}}
          <p class="text-dark">Total reports: {{$member->user->cases->count()}}</p>
        </div>

        <form action="{{ route('organization-member-remove-member', $member->id) }}" method="POST">
          @csrf
          <div class="form-group">
            <input type="hidden" id="status" name="status" value="remove">
            <input type="hidden" id="organization_id" name="organization_id" value={{$Organization->organization_id}}>
          </div>
          @method('PUT')
          <button class="btn btn-error" type="submit">Remove Member</button>
        </form>
      </div>
      @endforeach

      @else
      <div class="empty">
        <div class="empty-icon">
          <i class="icon icon-people"></i>
        </div>
        <p class="empty-title h5">Your organization is currently empty</p>
        <p class="empty-subtitle">Send out some invites to grow your organization!</p>

      </div>
      @endif

    </div>

    <div class="organization-member-container">
      <h6>Pending Members</h6>
      @if($pendingMembers->count() > 0)
      <div class="organization-member-card bg-secondary">

        <div class="empty-action">
          <form
            action="{{ route('organization-member-add-member', ['organization_id'=>$Organization->organization_id]) }}"
            method="POST">
            @csrf
            <div class="form-group input-group input-inline ">
              <input id="member_email" name="member_email" class="form-input" type="text" placeholder="Member Email">
              <button type="submit" class="btn btn-primary">Send Invite</button>
            </div>

            <div class="form-group">
              <input type="hidden" name="role" value="member">
            </div>
            @method('PUT')
          </form>
        </div>
      </div>
      @foreach ($pendingMembers as $Member)
      <div class="organization-member-card bg-secondary">

        <figure class="avatar avatar-lg"
          data-initial="{{substr($Member->user->first_name,0,1)}}{{substr($Member->user->last_name,0,1)}}"
          style="background-color: #5755d9;">
          @if ($Member->user->status == 'healthy')
          <i class="avatar-presence online"></i>
          @elseif ($Member->user->status == 'quarantine')
          <i class="avatar-presence away"></i>
          @else
          <i class="avatar-presence busy"></i>
          @endif
        </figure>

        <div class="org-member-info-card">
          {{-- <div class="card-title h5">{{$member->user->first_name}} {{$member->user->last_name}}</div>
          <div class="card-subtitle text-gray">{{$member->user->last_login}}</div> --}}
          <p class="text-dark">{{$Member->user->first_name}} {{$Member->user->last_name}}</p>
          <a class="card-subtitle text-primary" href="mailto:{{$Member->user->email}}">{{$Member->user->email}}</a>
          {{-- <p>Status: {{$member->user->status}}</p> --}}
          <p class="text-dark">Total reports: {{$Member->user->cases->count()}}</p>
        </div>

        <form action="{{ route('organization-member-remove-member', $Member->id) }}" method="POST">
          @csrf
          <div class="form-group">
            <input type="hidden" id="status" name="status" value="remove">
            <input type="hidden" id="organization_id" name="organization_id" value={{$Organization->organization_id}}>
          </div>
          @method('PUT')
          <button class="btn btn-error" type="submit">Remove Member</button>
        </form>
      </div>
      @endforeach
      @else
      <div class="empty">
        <div class="empty-icon">
          <i class="icon icon-people"></i>
        </div>
        <p class="empty-title h5">No pending invites</p>
        <p class="empty-subtitle">Invite a new member to your organization</p>
        <div class="empty-action">
          <form
            action="{{ route('organization-member-add-member', ['organization_id'=>$Organization->organization_id]) }}"
            method="POST">
            @csrf
            <div class="form-group input-group input-inline ">
              <input id="member_email" name="member_email" class="form-input" type="text" placeholder="Member Email">
              <button type="submit" class="btn btn-primary">Send Invite</button>
            </div>

            <div class="form-group">
              <input type="hidden" name="role" value="member">
            </div>
            @method('PUT')
          </form>
        </div>
      </div>

      @endif
    </div>
  </div>
</section>

<section class="body-section bg-secondary">
  <h2>Networks</h2>
  <div class="organization-member-container">
    @if($Organization->networks->count() > 0)
    <div class="organization-member-card bg-dark">

      <div class="empty-action">
        <form method="POST" action="{{ route('organization_networks.store')}}">
          @csrf
          <div class="form-group input-group input-inline ">
            <input id="network_name" name="network_name" class="form-input" type="text"
              placeholder="Create a New Network">
            <input id="organization_id" name="organization_id" type="hidden" value="{{$Organization->organization_id}}">
            <input id="creator_id" name="creator_id" type="hidden" value="{{$Organization->owner->id}}">
            <button type="submit" class="btn btn-primary">Create Network</button>
          </div>
        </form>
      </div>
    </div>
    @foreach($Organization->networks as $Network)
    <div class="organization-member-card bg-dark">

      <figure class="avatar avatar-lg" data-initial="{{substr($Network->network_name,0,1)}}"
        style="background-color: #5755d9;">
      </figure>

      <div class="org-member-info-card">

        {{-- <p class="text-dark">{{$member->user->first_name}} {{$member->user->last_name}}</p>
        <a class="card-subtitle text-primary" href="mailto:{{$member->user->email}}">{{$member->user->email}}</a>
        <p class="text-dark">Total reports: {{$member->user->cases->count()}}</p> --}}
        <p class="text-light">{{$Network->network_name}}</p>
        <p>Members: {{$Network->members->count()}}</p>
      </div>

      <a class="btn btn-primary" href="{{route('organization_networks.show', ['organization_network'=>$Network])}}">View
        Network</a>

    </div>
    @endforeach

    @else
    <div class="empty bg-dark">
      <div class="empty-icon">
        <i class="icon icon-people"></i>
      </div>
      <p class="empty-title h5">You currently have no sub networks in your organization</p>
      <p class="empty-subtitle">Create your first sub network by entering a name for it bellow</p>
      <div class="empty-action">
        <form method="POST" action="{{ route('organization_networks.store')}}">
          @csrf
          <div class="form-group input-group input-inline ">
            <input id="network_name" name="network_name" class="form-input" type="text" placeholder="Network Name">
            <input id="organization_id" name="organization_id" type="hidden" value="{{$Organization->organization_id}}">
            <input id="creator_id" name="creator_id" type="hidden" value="{{$Organization->owner->id}}">
            <button type="submit" class="btn btn-primary">Create Network</button>
          </div>

        </form>
      </div>
    </div>
    @endif

  </div>
</section>

<div class="footer-basic">
  <footer>
    {{-- <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i
          class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i
          class="icon ion-social-facebook"></i></a></div> --}}
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Home</a></li>
      <li class="list-inline-item"><a href="#">Services</a></li>
      <li class="list-inline-item"><a href="#">About</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
    </ul>
    <p class="copyright">© 2022</p>
  </footer>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>




@endsection