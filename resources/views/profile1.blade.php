<form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="profile_image" required>
    <button type="submit">Télécharger</button>
</form>