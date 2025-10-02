fetch('https://esenex.cl/wp/wp-json/wp/v2/posts?_embed')
    .then(response => response.json())
    .then(posts => {
        const blogContainer = document.getElementById('blog-container');
        posts.forEach(post => {
            const imageUrl = post._embedded?.['wp:featuredmedia']?.[0]?.source_url || 'images/default.jpg';
            const card = `
                <div class="blog-card">
                    <img src="${imageUrl}" alt="${post.title.rendered}" class="card-img-top">
                    <div class="card-body">
                        <h5>${post.title.rendered}</h5>
                        <a href="blog/post.html?id=${post.id}" class="btn btn-primary">Leer más</a>
                    </div>
                </div>`;
            blogContainer.innerHTML += card;
        });
    })
    .catch(error => console.error('Error cargando artículos:', error));




