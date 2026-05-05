<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectElement = document.getElementById("selectElementLuaran");
        let selectedValue = selectElement.value

        // INISIASI FORM INPUT
        const jenisBuku = document.getElementById("jenisBuku");
        const isbnBuku = document.getElementById("isbnBuku");
        const levelPublikasi = document.getElementById("levelPublikasi");
        const linkPublikasi = document.getElementById("linkPublikasi");
        const jenisPublikasi = document.getElementById("jenisPublikasi");
        const jenisHakCipta = document.getElementById("jenisHakCipta");
        const noHakCipta = document.getElementById("noHakCipta");
        jenisBuku.disabled = false;
        isbnBuku.disabled = false;
        levelPublikasi.disabled = false;
        linkPublikasi.disabled = false;
        jenisHakCipta.disabled = false;
        jenisPublikasi.disabled = false;
        noHakCipta.disabled = false;

        if (selectedValue === "1") {
            // Buku
            levelPublikasi.disabled = true;
            linkPublikasi.disabled = true;
            jenisHakCipta.disabled = true;
            noHakCipta.disabled = false;
            jenisPublikasi.disabled = true;
        } else if (selectedValue === "2") {
            // Publikasi
            jenisBuku.disabled = true;
            isbnBuku.disabled = true;
            jenisHakCipta.disabled = true;
            noHakCipta.disabled = true;
        } else if (selectedValue === "3") {
            // Prosiding
            jenisBuku.disabled = true;
            isbnBuku.disabled = true;
            jenisHakCipta.disabled = true;
            noHakCipta.disabled = true;
        } else if (selectedValue === "4") {
            // HKI
            levelPublikasi.disabled = true;
            linkPublikasi.disabled = true;
            jenisBuku.disabled = true;
            isbnBuku.disabled = true;
            jenisPublikasi.disabled = true;
        } else {
        }

        // SAAT INPUT LUARAN DIEDIT CHANGE
        selectElement.addEventListener("change", (event) => {
            const selectedValue = event.target.value;

            jenisBuku.disabled = false;
            isbnBuku.disabled = false;
            levelPublikasi.disabled = false;
            linkPublikasi.disabled = false;
            jenisHakCipta.disabled = false;
            jenisPublikasi.disabled = false;
            noHakCipta.disabled = false;

            if (selectedValue === "1") {
                // Buku
                levelPublikasi.disabled = true;
                linkPublikasi.disabled = true;
                jenisHakCipta.disabled = true;
                noHakCipta.disabled = false;
                jenisPublikasi.disabled = true;
            } else if (selectedValue === "2") {
                // Publikasi
                jenisBuku.disabled = true;
                isbnBuku.disabled = true;
                jenisHakCipta.disabled = true;
                noHakCipta.disabled = true;
            } else if (selectedValue === "3") {
                // Prosiding
                jenisBuku.disabled = true;
                isbnBuku.disabled = true;
                jenisHakCipta.disabled = true;
                noHakCipta.disabled = true;
            } else if (selectedValue === "4") {
                // HKI
                levelPublikasi.disabled = true;
                linkPublikasi.disabled = true;
                jenisBuku.disabled = true;
                isbnBuku.disabled = true;
                jenisPublikasi.disabled = true;
            } else {
            }
        });

        // DISABLE OPTION SELECT LEVEL PUBLIKASI
        const jp = document.getElementById("jenisPublikasi");
        const lp1 = document.getElementById("levelPublikasi").options[1]
        const lp2 = document.getElementById("levelPublikasi").options[2]
        const lp3 = document.getElementById("levelPublikasi").options[3]
        const lp4 = document.getElementById("levelPublikasi").options[4]
        const lp5 = document.getElementById("levelPublikasi").options[5]
        const lp6 = document.getElementById("levelPublikasi").options[6]
        const lp7 = document.getElementById("levelPublikasi").options[7]
        const lp8 = document.getElementById("levelPublikasi").options[8]
        const lp9 = document.getElementById("levelPublikasi").options[9]
        const lp10 = document.getElementById("levelPublikasi").options[10]
        const lp11 = document.getElementById("levelPublikasi").options[11]
        const lp12 = document.getElementById("levelPublikasi").options[12]
        const lp13 = document.getElementById("levelPublikasi").options[13]
        const lp14 = document.getElementById("levelPublikasi").options[14]
        const lp15 = document.getElementById("levelPublikasi").options[15]
        const lp16 = document.getElementById("levelPublikasi").options[16]
        const lp17 = document.getElementById("levelPublikasi").options[17]
        jp.addEventListener('change', (event) => {
            lp1.disabled = true;
            lp2.disabled = true;
            lp3.disabled = true;
            lp4.disabled = true;
            lp5.disabled = true;
            lp6.disabled = true;
            lp7.disabled = true;
            lp8.disabled = true;
            lp9.disabled = true;
            lp10.disabled = true;
            lp11.disabled = true;
            lp12.disabled = true;
            lp13.disabled = true;
            lp14.disabled = true;
            lp15.disabled = true;
            lp16.disabled = true;
            lp17.disabled = true;

            const jpSelected = event.target.value;
            console.log('Selected value:', jpSelected);
            if (jpSelected == 1) {
                lp1.disabled = false;
                lp2.disabled = false;
                lp3.disabled = false;
                lp4.disabled = false;
            } if (jpSelected == 2) {
                lp5.disabled = false;
                lp6.disabled = false;
                lp7.disabled = false;
                lp8.disabled = false;
            } if (jpSelected == 3) {
                lp9.disabled = false;
                lp10.disabled = false;
                lp11.disabled = false;
                lp12.disabled = false;
                lp13.disabled = false;
                lp14.disabled = false;
            } if (jpSelected == 4) {
                lp9.disabled = false;
                lp10.disabled = false;
                lp11.disabled = false;
                lp12.disabled = false;
                lp13.disabled = false;
                lp14.disabled = false;
                lp15.disabled = false;
                lp16.disabled = false;
                lp17.disabled = false;
            } if (jpSelected == 5) {
                lp15.disabled = false;
            } if (jpSelected == 6) {
                lp16.disabled = false;
            } if (jpSelected == 7) {
                lp17.disabled = false;
            }
        });

        // JIKA DI MENU EDIT
        const jpSelected = document.getElementById("jenisPublikasi").value;
        lp1.disabled = true;
        lp2.disabled = true;
        lp3.disabled = true;
        lp4.disabled = true;
        lp5.disabled = true;
        lp6.disabled = true;
        lp7.disabled = true;
        lp8.disabled = true;
        lp9.disabled = true;
        lp10.disabled = true;
        lp11.disabled = true;
        lp12.disabled = true;
        lp13.disabled = true;
        lp14.disabled = true;
        lp15.disabled = true;
        lp16.disabled = true;
        lp17.disabled = true;
        console.log('Selected value:', jpSelected);
        if (jpSelected == 1) {
            lp1.disabled = false;
            lp2.disabled = false;
            lp3.disabled = false;
            lp4.disabled = false;
        } if (jpSelected == 2) {
            lp5.disabled = false;
            lp6.disabled = false;
            lp7.disabled = false;
            lp8.disabled = false;
        } if (jpSelected == 3) {
            lp9.disabled = false;
            lp10.disabled = false;
            lp11.disabled = false;
            lp12.disabled = false;
            lp13.disabled = false;
            lp14.disabled = false;
        } if (jpSelected == 4) {
            lp9.disabled = false;
            lp10.disabled = false;
            lp11.disabled = false;
            lp12.disabled = false;
            lp13.disabled = false;
            lp14.disabled = false;
            lp15.disabled = false;
            lp16.disabled = false;
            lp17.disabled = false;
        } if (jpSelected == 5) {
            lp15.disabled = false;
        } if (jpSelected == 6) {
            lp16.disabled = false;
        } if (jpSelected == 7) {
            lp17.disabled = false;
        }

        // TAMBAH FORM INPUT PENULIS
        const btn_plus_penulis = document.getElementById("btn_tambah_penulis");
        btn_plus_penulis.addEventListener("click", function () {
            let radioButtonCh = document.getElementsByName('penulis_utama')[0];

            let parent = document.getElementById('formPenulisParent');
            let elem = parent.querySelector('.input_penulis_element');
            let clone = elem.cloneNode(true);
            parent.appendChild(clone);

            let radios3 = document.getElementsByName('penulis_utama');
            let formPenulis = document.getElementsByClassName('form_input_penulis');
            let nop = 0;
            for (let i = 0; i < radios3.length; i++) {
                if (i == 0) {
                    if (radioButtonCh.checked = true) {
                        document.getElementsByName('penulis_utama')[0].checked = "checked";
                    }
                }
                if (i == (radios3.length - 1)) {
                    document.getElementsByName('penulis_bank[]')[i].value = "";
                    document.getElementsByName('penulis_norek[]')[i].value = "";
                    document.getElementsByName('penulis[]')[i].value = "";
                }
                document.getElementsByName('penulis_utama')[i].value = i;
            }

        });

        // HILANGKAN NOREK DAN BANK SAAT MEMILIH PENULIS DARI PIHAK LUAR/EKSTERNAL
        const elPenulisJabatan = document.getElementsByClassName('penulis_jabatan');
        const tjb_child = document.getElementsByClassName('input_penulis_bank');
        const tnr_child = document.getElementsByClassName('input_penulis_norek');
        for (let i = 0; i < elPenulisJabatan.length; i++) {
            if (elPenulisJabatan[i].value == 3) {
                tjb_child[i].type = "hidden"
                tnr_child[i].type = "hidden"
                tjb_child[i].value = ""
                tnr_child[i].value = ""
            } else {
                tjb_child[i].type = "text"
                tnr_child[i].type = "number"
            }
        }
        document.addEventListener('change', (event) => {
            if (event.target.classList.contains('penulis_jabatan')) {
                const tjb = event.target.parentElement;
                const tjb_child = tjb.querySelector('.input_penulis_bank');
                const tnr_child = tjb.querySelector('.input_penulis_norek');

                // TIDAK DIIZINKAN PENULIS PERTAMA DARI LUAR/EKSTERNAL
                if (event.target.value == 3) {
                    if (tjb.querySelector('.form_input_penulis_utama').value != 0) {
                        tjb_child.type = "hidden"
                        tnr_child.type = "hidden"
                        tjb_child.value = ""
                        tnr_child.value = ""
                    }
                } else {
                    tjb_child.type = "text"
                    tnr_child.type = "number"
                }
            }
        })

        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('btnDeleteElementPenulis')) {
                // check apakah elemen tinggal satu
                const elements = document.getElementsByClassName('btnDeleteElementPenulis');
                if (elements.length === 1) {
                    // tidak lakukan apa-apa
                } else {
                    const elementPenulisHapus = event.target.parentElement;
                    elementPenulisHapus.remove();

                    // UPDATE VALUE RADIO BUTTON
                    let radios3 = document.getElementsByName('penulis_utama');
                    let formPenulis = document.getElementsByClassName('form_input_penulis');
                    let nop = 0;
                    for (let i = 0; i < radios3.length; i++) {
                        document.getElementsByName('penulis_utama')[i].value = i;
                    }
                }

            }
            if (event.target.classList.contains('btnDeleteElementPenulisX')) {
                // check apakah elemen tinggal satu
                const elements = document.getElementsByClassName('btnDeleteElementPenulis');
                if (elements.length === 1) {
                    // tidak lakukan apa-apa
                } else {
                    const elementPenulisHapus = event.target.parentElement.parentElement;
                    elementPenulisHapus.remove();

                    // UPDATE VALUE RADIO BUTTON
                    let radios3 = document.getElementsByName('penulis_utama');
                    let formPenulis = document.getElementsByClassName('form_input_penulis');
                    let nop = 0;
                    for (let i = 0; i < radios3.length; i++) {
                        document.getElementsByName('penulis_utama')[i].value = i;
                    }
                }

            }
        });
    });



</script>