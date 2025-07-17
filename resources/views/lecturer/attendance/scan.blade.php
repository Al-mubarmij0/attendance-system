@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4>QR Code Attendance Scanner</h4>

    <div class="mb-3">
        <label for="course_id" class="form-label">Select Course</label>
        <select id="course_id" class="form-select">
            <option value="">-- Select a Course --</option>
            @foreach(Auth::user()->lecturer->courses ?? [] as $course)
                <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
            @endforeach
        </select>
    </div>

    <div id="scanner-controls" class="mb-3" style="display: none;">
        <button id="startScannerBtn" class="btn btn-primary">Start Scanner</button>
    </div>

    <video id="preview" width="100%" style="max-width: 500px; display: none;" autoplay muted></video>

    <div class="mt-3">
        <div id="scan-result" class="alert d-none"></div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Load ZXing QR code reader via ES module from Skypack -->
<script type="module">
    import { BrowserQRCodeReader } from 'https://cdn.skypack.dev/@zxing/browser';

    document.addEventListener('DOMContentLoaded', () => {
        const courseSelect = document.getElementById('course_id');
        const preview = document.getElementById('preview');
        const startBtn = document.getElementById('startScannerBtn');
        const scannerControls = document.getElementById('scanner-controls');
        const resultBox = document.getElementById('scan-result');

        let codeReader;

        function showMessage(msg, type = 'success') {
            resultBox.className = `alert alert-${type}`;
            resultBox.textContent = msg;
            resultBox.classList.remove('d-none');
        }

        function markAttendance(studentId) {
            fetch("{{ route('lecturer.attendance.mark') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    student_id: studentId,
                    course_id: courseSelect.value
                })
            })
            .then(res => res.json())
            .then(data => showMessage(data.message, data.success ? 'success' : 'danger'))
            .catch(() => showMessage("Error marking attendance", 'danger'));
        }

        courseSelect.addEventListener('change', () => {
            scannerControls.style.display = courseSelect.value ? 'block' : 'none';
            preview.style.display = 'none';
            resultBox.classList.add('d-none');
        });

        startBtn.addEventListener('click', async () => {
            preview.style.display = 'block';
            codeReader = new BrowserQRCodeReader();

            try {
                const devices = await BrowserQRCodeReader.listVideoInputDevices();
                if (!devices.length) return showMessage("No camera found", "danger");

                codeReader.decodeFromVideoDevice(devices[0].deviceId, preview, (result, err) => {
                    if (result) {
                        const id = parseInt(result.text);
                        if (!isNaN(id)) {
                            codeReader.reset();
                            markAttendance(id);
                        } else {
                            showMessage("Invalid QR code", 'danger');
                        }
                    }
                });
            } catch (err) {
                showMessage("Error accessing camera: " + err, 'danger');
            }
        });
    });
</script>
@endsection
