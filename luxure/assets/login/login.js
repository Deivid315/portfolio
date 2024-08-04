
    // Obtém os parâmetros da URL
    const urlParams = new URLSearchParams(window.location.search);

    // Verifica se o parâmetro 'message' está presente na URL
    if (urlParams.has('message')) {
        // Remove o parâmetro 'message'
        urlParams.delete('message');
    
        // Obtém a URL sem o parâmetro 'message'
        let newUrl;
        if (urlParams.toString()) {
            // Se houver outros parâmetros, mantenha o símbolo de interrogação
            newUrl = window.location.pathname + '?' + urlParams.toString();
        } else {
            // Se não houver outros parâmetros, remova o símbolo de interrogação
            newUrl = window.location.pathname;
        }
    
        // Modifica a URL atual sem redirecionar
        history.replaceState({}, '', newUrl);
    }
    
        