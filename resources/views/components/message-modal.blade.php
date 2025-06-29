<div id="messageModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; z-index:9999; background:rgba(0,0,0,0.4);">
    <div style="display:flex; align-items:center; justify-content:center; height:100%;">
        <div style="background:white; border-radius:16px; max-width:400px; width:100%; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
            <div style="padding:24px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between;">
                <h3 style="font-size:18px; font-weight:bold; color:#2563eb; margin:0;">Enviar Mensaje</h3>
                <button onclick="closeMessageModal()" style="background:none; border:none; font-size:20px; color:#2563eb; cursor:pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="messageForm" method="POST" action="{{ route('admin.users.send-message') }}" style="padding:24px;">
                @csrf
                <input type="hidden" name="user_id" id="messageUserId">
                <div style="margin-bottom:16px;">
                    <label for="messageSubject" style="font-size:14px; color:#374151; font-weight:600;">Asunto</label>
                    <input type="text" name="subject" id="messageSubject" required style="width:100%; padding:8px; border:1px solid #d1d5db; border-radius:8px; margin-top:4px;">
                </div>
                <div style="margin-bottom:16px;">
                    <label for="messageBody" style="font-size:14px; color:#374151; font-weight:600;">Mensaje</label>
                    <textarea name="message" id="messageBody" rows="4" required style="width:100%; padding:8px; border:1px solid #d1d5db; border-radius:8px; margin-top:4px;"></textarea>
                </div>
                <div style="display:flex; gap:8px;">
                    <button type="button" onclick="closeMessageModal()" style="flex:1; padding:10px; background:#6b7280; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer;">Cancelar</button>
                    <button type="submit" style="flex:1; padding:10px; background:#2563eb; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer;">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function openMessageModal(userId) {
        document.getElementById('messageUserId').value = userId;
        document.getElementById('messageSubject').value = '';
        document.getElementById('messageBody').value = '';
        document.getElementById('messageModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    function closeMessageModal() {
        document.getElementById('messageModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') closeMessageModal();
    });
    document.getElementById('messageModal').addEventListener('click', function(event) {
        if (event.target === this) closeMessageModal();
    });
</script> 