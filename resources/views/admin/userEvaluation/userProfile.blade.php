<style>

.nav-profile {
    justify-content: center;
    align-items: center;
    display: flex;
    padding-top: 10px;
}
   .profile-card {
  width: 500px;
  height: 150px;
  background: #f7f7f7;
  border-radius: 15px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  display: flex;
  align-items: center;
  padding: 20px;
}

.profile-image {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  margin-right: 20px;
}

.user-info {
  display: flex;
  flex-direction: column;
}

.user-name {
  font-size: 22px;
  font-weight: bold;
  margin: 0;
  color: #333;
}

.user-dob,
.user-email {
  font-size: 16px;
  color: #666;
  margin: 4px 0;
}

</style>
<div class="profile-card">
  <img src="https://avatars.dicebear.com/api/initials/John-Doe.svg" alt="User Image" class="profile-image">
  <div class="user-info">
    <h2 class="user-name">{{$user->name}}</h2>
    <p class="user-dob">DOB: {{ isset($user->dob) ? $user->dob : 'N/A' }}</p>
    
    <p class="user-email">{{$user->email}}</p>
  </div>
</div>


