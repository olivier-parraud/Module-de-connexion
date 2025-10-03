


<footer class="footer">
    <p><i class="fas fa-code"></i> &copy; 2025 Module de Connexion - Conçu avec passion pour Ely</p>
</footer>

<script>
    // Smooth animations and interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Add sparkle effect on hover
        const buttons = document.querySelectorAll('.nav-button');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.05)';
            });
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Typing effect for title (optional enhancement)
        const title = document.querySelector('.header h1');
        const originalText = title.innerHTML;
        title.style.borderRight = '3px solid white';

        // Add some interactivity
        console.log('🚀 Module de Connexion Premium chargé avec succès!');
    });
</script>
</body>
</html>