<section class="overlay"></section>
<!-- JavaScript Bundle with Popper -->
<script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
<!-- <script src="../assets/js/jquery-3.6.1.min.js"></script> -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../assets/js/swal.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script>
    const navBar = document.querySelector("nav"),
        menuBtns = document.querySelectorAll(".menu-icon"),
        overlay = document.querySelector(".overlay");

    menuBtns.forEach((menuBtn) => {
        menuBtn.addEventListener("click", () => {
            navBar.classList.toggle("open");
        });
    });

    overlay.addEventListener("click", () => {
        navBar.classList.remove("open");
    });

    function logout() {
                Swal.fire({
                        title: 'ต้องการออกจากระบบ?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ตกลง',
                        cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                        if (result.isConfirmed) {
                                $.ajax({
                                        url: 'function/action.php',
                                        type: 'post',
                                        data: {
                                                logout: 1
                                        },
                                        success: function(res) {
                                                Swal.fire(
                                                        'ออกจากระบบสำเร็จ!',
                                                        '',
                                                        'success'
                                                )
                                                setTimeout(() => {
                                                        location.reload()
                                                }, 700)
                                        }
                                })

                        }
                })

        }
</script>
</body>
</html>