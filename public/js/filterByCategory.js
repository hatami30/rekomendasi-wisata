// document.querySelectorAll('.filter-item').forEach(item => {
//     item.addEventListener('click', event => {
//         event.preventDefault();
//         const slug = event.target.getAttribute('data-name');
//         filterByCategory(slug);
//     });
// });

// function displayWisata(data) {
//     const rekomendasiSection = document.querySelector('.rekomendasi .container .row');
//     rekomendasiSection.innerHTML = '';

//     data.forEach(wisata => {
//         const card = document.createElement('div');
//         card.classList.add('col-md-3', 'mb-4');
//         card.innerHTML = `
//             <div class="card h-100">
//                 <img src="${wisata.gambar_wisata}" class="card-img-top img-fluid rounded"
//                     style="object-fit: cover; width: 100%; height: 200px;" alt="${wisata.nama_wisata}">
//                 <div class="card-body">
//                     <h5 class="card-title">${wisata.nama_wisata}</h5>
//                     <a href="/wisata/${wisata.id}" class="btn btn-primary">Detail <i
//                             data-feather="arrow-right"></i></a>
//                 </div>
//             </div>
//         `;
//         rekomendasiSection.appendChild(card);
//     });
// }

// function filterByCategory(slug) {
//     fetch(`/rekomendasi-wisata/${slug}`)
//         .then(response => response.json())
//         .then(data => {
//             displayWisata(data);
//         })
//         .catch(error => console.error('Error:', error));
// }
