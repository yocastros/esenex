// Obtener el ID del artículo desde los parámetros de la URL
const urlParams = new URLSearchParams(window.location.search);
const postId = urlParams.get('id');

// Validar que exista un ID
if (postId) {
  // Hacer la petición a la API
  fetch(`https://esenex.cl/wp/wp-json/wp/v2/posts/${postId}?_embed`)
    .then(response => {
      if (!response.ok) {
        throw new Error('Error al obtener el artículo');
      }
      return response.json();
    })
    .then(post => {
      // Actualizar el contenido del DOM
      document.getElementById('post-title').innerText = post.title.rendered;
      document.getElementById('post-content').innerHTML = post.content.rendered;

      const imageUrl = post._embedded && post._embedded['wp:featuredmedia']
        ? post._embedded['wp:featuredmedia'][0].source_url
        : 'ruta/a/una/imagen/por_defecto.jpg';

      document.getElementById('post-image').src = imageUrl;
    })
    .catch(error => {
      console.error('Error al cargar el artículo:', error);
      document.getElementById('post-content').innerText = 'No se pudo cargar el artículo.';
    });
} else {
  document.getElementById('post-content').innerText = 'ID del artículo no válido.';
}
