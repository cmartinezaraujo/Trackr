@extends('layout')

@section('content')

<!-- 
  NAVIGATION TOP
  -WELCOME MESSAGE
  -NOTIFICATION DROP DOWN
-->


<header class="navbar">
  <section class="navbar-section">

  </section>

  <section class="navbar-center">
    <h1 id="navHeader">Welcome {{$User->first_name}}</h1>
  </section>

  <section class="navbar-section">

    <div class="popover popover-bottom">
      <span class="badge" data-badge="{{$Notifications->count()}}">
        <a href="{{ route('user-notification-center', $User->id) }}" method="GET">Notifications</a>
      </span>
      <div class="popover-container">
        @foreach ($User->notifications as $notification)
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
  <div class="user section-container">
    <div class="user-card">
      <figure id="profile-avitar" class="avatar avatar-xl"
        data-initial="{{substr($User->first_name,0,1)}}{{substr($User->last_name,0,1)}}"
        style="background-color: #5755d9;">
        @if ($User->status == 'healthy')
        <i class="avatar-presence online"></i>
        @elseif ($User->status == 'quarantine')
        <i class="avatar-presence away"></i>
        @else
        <i class="avatar-presence busy"></i>
        @endif
      </figure>
      <p>Your current status {{$User->status}}</p>

      <p>You have reported {{$User->cases->count()}} cases</p>
      <div class="buttons-row">
        <a class="btn btn-primary" href="#updateStatus">Update Status</a>
        <a class="btn btn-primary" href="{{route('make-report', ['user_id'=>$User->id])}}">Make Report</a>
      </div>
    </div>
    <div class="user-card">
      <h2>Your Network Overview</h2>
      <p>There have been a total of {{$Reports}} reported cases from
        contacts in your network.
      </p>
      <a class="btn btn-primary" href="{{route('reports.user', ['id'=>$User->id])}}">See all reports</a>
      <br>
      <p>Stay up to date with your networks weekly stats overview.</p>
      <a class="btn btn-primary user-btn" href="{{route('show-user-graphs', $User)}}">View
        Network Statistics</a>
    </div>
  </div>
</section>

<!-- UPDATE MODAL DO NOT MOVE-->
<div class="modal modal-sm" id="updateStatus">
  <a href="#close" class="modal-overlay" aria-label="Close"></a>
  <div class="modal-container">
    <form action="{{ route('user-update-status', $User->id) }}" method="POST">
      @csrf
      <div class="form-group">
        <select class="form-select" name="new_status">
          <option>Choose a new status</option>
          <option value="healthy">Healthy</option>
          <option value="quarantine">Quarantine</option>
          <option value="sick">Sick</option>
        </select>
      </div>
      @method('PUT')
      <button class="btn btn-success" type="submit">Submit</button>
    </form>
  </div>
</div>

<!--
  USER NETWORK INFORMATION
  -TOTAL REPORT COUNT
  -PENDING CONTACTS TABLE
  -PENDING CONTACTS TABLE
-->
<section class="body-section dark">
  <h2 class="text-light">Contact Network</h2>
  @if ($Network->count() > 0)
  <div class="contact-card-outer-container">
    <div class="contact-card-container">
      <div class="contact-card">
        <h5>Add New Contact</h5>
        <form action="{{ route('add-contact', ['requester_id'=>$User->id]) }}" method="POST">
          @csrf
          <div class="form-group">
            <input id="contact_email" name="contact_email" class="form-input" type="text" placeholder="Contact Email">
            <button type="submit" class="btn btn-primary">Send Invite</button>
          </div>
          @method('PUT')
        </form>
      </div>
      @foreach($Network as $Contact)
      <div class="contact-card">
        <div class="card-image">
          <figure class="avitar-card avatar avatar-xl"
            data-initial="{{substr($Contact->first_name,0,1)}}{{substr($Contact->last_name,0,1)}}"
            style="background-color: #5755d9;">
            @if ($Contact->status == 'healthy')
            <i class="avatar-presence online"></i>
            @elseif ($Contact->status == 'quarantine')
            <i class="avatar-presence away"></i>
            @else
            <i class="avatar-presence busy"></i>
            @endif
          </figure>
        </div>
        <div class="card-header">
          <div class="card-title h5">{{$Contact->first_name}} {{$Contact->last_name}}</div>
          <div class="card-subtitle text-gray">{{$Contact->last_login}}</div>
          <br>
        </div>
        <div class="card-body">
          <p>Status: {{$Contact->status}}</p>
          <p>Total reports: {{$Contact->cases->count()}}</p>
        </div>
        <div class="card-footer">
          <form action="{{ route('contacts.destroy', $User->id) }}" method="POST">
            @csrf
            <input type="hidden" id="contact_id" name="contact_id" value={{$Contact->id}}>
            @method('DELETE')
            <button class="btn btn-error" type="submit">Remove</button>
          </form>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @else
  <div class="empty">
    <div class="empty-icon">
      <i class="icon icon-people"></i>
    </div>
    <p class="text-dark h5">You currently have no contacts in your network.</p>
    <p class="empty-subtitle">Enter a contacts email bellow to add your first contact to your network</p>
    <div class="empty-action">
      <form action="{{ route('add-contact', ['requester_id'=>$User->id]) }}" method="POST">
        @csrf
        <div class="form-group input-group input-inline ">
          <input id="contact_email" name="contact_email" class="form-input" type="text" placeholder="Contact Email">
          <button type="submit" class="btn btn-primary">Send Request</button>
        </div>
        @method('PUT')
      </form>
    </div>
  </div>
  @endif

  @if($PendingContacts->count() > 0)
  <h3 class="text-light heading-bottom">Pending Contact Requests</h3>
  <div class="pendig-contacts-container">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th class="text-light">Name</th>
          <th></th>
          <th class="text-light">Email</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <div class="pending-contacts-table">
        <tbody>
          @foreach($PendingContacts as $Contact)
          <tr class="active">
            <td>{{$Contact->first_name}}</td>
            <td>{{$Contact->last_name}}</td>
            <td>{{$Contact->email}}</td>
            <td>
              <form method="post"
                action="{{ route('accept-contact-request', ['user_id'=>$User->id, 'contact_id'=>$Contact->id])}}">
                @csrf
                @method('PUT')
                <button class="btn btn-success" type="submit">Accept</button>
              </form>
            </td>
            <td>
              <form action="{{ route('contacts.destroy', $User->id) }}" method="POST">
                @csrf
                <input type="hidden" id="contact_id" name="contact_id" value={{$Contact->id}}>
                @method('DELETE')
                <button class="btn btn-error" type="submit">Reject</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </div>
    </table>
  </div>
  @endif

</section>


<section class="body-section bg-secondary">
  @if(sizeof($NetworkOrg) > 0)
  <h3>Organizations</h3>
  <div class="organization-card-outer-container">
    <div class="organization-card-container">
      @foreach($NetworkOrg as $Organization)
      <div class="organization-card bg-dark">
        <div class="card-image">
          <figure class="avitar-card avatar avatar-xl"
            data-initial="{{substr($Organization['org']->organization_name,0,1)}}" style="background-color: #5755d9;">
          </figure>
        </div>
        <div class="card-header">
          <div class="card-title h5">{{$Organization['org']->organization_name}}</div>
          <div class="card-subtitle text-gray">Owner: {{$Organization['org']->owner->first_name}}
            {{$Organization['org']->owner->last_name}}</div>
          <br>
        </div>
        <div class="card-body">
          <p>Total Reports: {{$Organization['reportsTotal']}}</p>
          <p>Positive Reports: {{$Organization['reportsSick']}}</p>
          <p>Exposure Reports: {{$Organization['reportsExposed']}}</p>
        </div>
        <div class="card-footer">
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  @if($PendingOrganizations->count() > 0)
  <h3 class="heading-bottom">Pending Organization Invites</h3>
  <div class="pending-organization-container">
    <table class="table bg-dark">
      <thead class="bg-secondary">
        <tr>
          <th class="text-dark">Organization Name</th>
          <th class="text-dark">Owner</th>
          <th class="text-dark">Sent on</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($PendingOrganizations as $Invitation)
        <tr class="">
          <td>{{$Invitation->organization->organization_name}}</td>
          <td>{{$Invitation->organization->owner->first_name}}</td>
          <td>{{$Invitation->created_at}}</td>
          <td>
            <form
              action="{{route('organization-member-respond-to-invite', ['organization_member'=>$Invitation->id, 'status'=>'accepted'])}}"
              method="POST">
              @method('PUT')
              @csrf
              <button class="btn btn-success" type="submit">Join</button>
            </form>
          </td>
          <td>
            <form
              action="{{route('organization-member-respond-to-invite', ['organization_member'=>$Invitation->id, 'status'=>'rejected'])}}"
              method="POST">
              @method('PUT')
              @csrf
              <button class="btn btn-error" type="submit">Reject</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
  @endif

</section>

<div class="footer-basic">
  <footer>
    <div class="social"></div>
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
</body>


@endsection