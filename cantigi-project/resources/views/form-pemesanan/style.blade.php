<style>
    body { 
      min-height: 100vh;
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .glass-card {
      backdrop-filter: blur(16px);
      background: rgba(255, 255, 255, 0.95);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
    }
    
    .input-group {
      position: relative;
      margin-bottom: 1rem;
    }
    
    .input-field {
      transition: all 0.3s ease;
      border: 2px solid #e1e5e9;
    }
    
    .input-field:focus {
      border-color: #10b981;
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
      outline: none;
    }
    
    .checkbox-custom {
      position: relative;
      display: inline-block;
      width: 20px;
      height: 20px;
    }
    
    .checkbox-custom input {
      opacity: 0;
      position: absolute;
      width: 100%;
      height: 100%;
      margin: 0;
      cursor: pointer;
    }
    
    .checkbox-custom .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 20px;
      width: 20px;
      background-color: rgba(255, 255, 255, 0.9);
      border: 2px solid rgba(255, 255, 255, 0.5);
      border-radius: 4px;
      transition: all 0.3s ease;
    }
    
    .checkbox-custom input:checked ~ .checkmark {
      background-color: rgba(255, 255, 255, 1);
      border-color: rgba(255, 255, 255, 1);
    }
    
    .checkbox-custom .checkmark:after {
      content: "";
      position: absolute;
      display: none;
      left: 6px;
      top: 2px;
      width: 6px;
      height: 10px;
      border: solid #10b981;
      border-width: 0 2px 2px 0;
      transform: rotate(45deg);
    }
    
    .checkbox-custom input:checked ~ .checkmark:after {
      display: block;
    }
    
    .option-card {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      transition: all 0.3s ease;
      cursor: pointer;
    }
    
    .option-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
    }
    
    .option-card.selected {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
    }
    
    .date-section {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      transition: all 0.3s ease;
    }
    
    .date-section:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2);
    }
    
    .booking-btn {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .booking-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 35px rgba(245, 158, 11, 0.4);
    }
    
    .booking-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }
    
    .booking-btn:hover::before {
      left: 100%;
    }
    
    .price-tag {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .animate-slide-in {
      animation: slideIn 0.6s ease-out forwards;
    }
    
    .section-divider {
      height: 1px;
      background: linear-gradient(90deg, transparent, #e1e5e9, transparent);
      margin: 1.5rem 0;
    }
  </style>