<style>
    body { font-family: 'roboto', sans-serif; }
    
    /* Pagination Container */
    .pagination-container {
      position: relative;
      overflow: hidden;
      width: 100%;
    }
    
    /* Slides Container */
    .slides-container {
      display: flex;
      transition: transform 0.5s ease-in-out;
      width: 100%;
    }
    
    /* Individual Slide */
    .slide {
      min-width: 100%;
      flex-shrink: 0;
    }
    
    /* Animation classes */
    .slide-enter {
      transform: translateX(100%);
    }
    
    .slide-enter-active {
      transform: translateX(0);
    }
    
    .slide-exit {
      transform: translateX(0);
    }
    
    .slide-exit-active {
      transform: translateX(-100%);
    }
  </style>