window.showModal = function(date,fetchUrl) {
    // 現在のURLにAjaxリクエストを飛ばす例
    fetch(fetchUrl, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('サーバから届いたデータ:', data);
        console.log(data['html']);
        if (data.status === 'success') {
            const area = document.getElementById('form-display-area');
            const back_area = document.getElementById('form-display-area-overray');
            back_area.style.display = "block";
            area.style.display = "block";
            area.innerHTML = data.html;

            console.log(date);

            // 3. クリックした日付をフォームの隠しフィールドにセット
            document.getElementById('form-visit-date').value = date;
        }
    })
    .catch(error => console.error('エラー発生:', error));
};

window.closeModal = function() {
    document.getElementById('form-display-area-overray').style.display = 'none';
    document.getElementById('form-display-area').style.display = 'none';
};

window.uploadImg = function(element) {
    const file = element.files[0];
    if (!file) return;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const uploadToken = document.getElementById('upload_token').value;

    const formData = new FormData();
    formData.append('image', file);
    formData.append('upload_token', uploadToken);
    fetch('/admin/sauna/upload-tmp', {
    method: 'POST',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrfToken,
    },
    body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data['msg']);
            // プレビュー表示などの処理
            console.log('保存先パス:', data.path);
            const iconUrl = "/images/icons/batsu.svg";
            const previewContainer = document.getElementById('image_preview_container');
            previewContainer.innerHTML = `<img id="tmp_img_${data.id}" class="image_preview" src="${data.url}" style="width:200px; border-radius:8px;">
            <img class="delete-image" src="${iconUrl}" style="border-radius:8px;" onclick="if(confirm('画像を削除しますか？')){ deleteTmpImg(${data.id}, this); }">`;
        }
    })
    .catch(error => console.error('エラー発生:', error));
    element.value = '';
};

window.deleteTmpImg = function(imgId,element) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formData = new FormData();
    const input = document.getElementById('image_preview_container');
    formData.append('id', imgId);
    fetch('/admin/sauna/delete-tmp', {
    method: 'POST',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrfToken,
    },
    body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data['msg']);
            const previewContainer = document.getElementById('image_preview_container');
            const tmp_img = document.getElementById(`tmp_img_${imgId}`);
            element.remove();
            tmp_img.remove();
        }
    })
    .catch(
        error => {
            console.error('エラー発生:', error);
        });
};

