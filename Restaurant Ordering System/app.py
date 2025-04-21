from flask import Flask, render_template
from flask_login import LoginManager
from config import Config
from models import db, User, MenuItem, Order, OrderItem
import os

def create_app(config_class=Config):
    app = Flask(__name__)
    app.config.from_object(config_class)
    
    # Initialize extensions
    db.init_app(app)
    login_manager = LoginManager()
    login_manager.init_app(app)
    login_manager.login_view = 'auth.login'
    
    @login_manager.user_loader
    def load_user(user_id):
        return User.query.get(int(user_id))
    
    # Register blueprints
    from routes.auth import auth_bp
    app.register_blueprint(auth_bp)
    
    from routes.customer import customer_bp
    app.register_blueprint(customer_bp)
    
    from routes.admin import admin_bp
    app.register_blueprint(admin_bp)
    
    # Create database tables
    with app.app_context():
        db.create_all()
        seed_data()
    
    @app.route('/')
    def index():
        return render_template('index.html')
    
    return app

def seed_data():
    # Check if there's any data already
    if MenuItem.query.count() == 0:
        # Add some menu items
        pizza = MenuItem(name="Margherita Pizza", description="Classic tomato and cheese pizza", price=9.99, category="Pizza", is_available=True)
        pasta = MenuItem(name="Spaghetti Carbonara", description="Creamy pasta with bacon", price=8.99, category="Pasta", is_available=True)
        salad = MenuItem(name="Caesar Salad", description="Fresh salad with Caesar dressing", price=6.99, category="Salad", is_available=True)
        burger = MenuItem(name="Cheeseburger", description="Classic beef burger with cheese", price=7.99, category="Burger", is_available=True)
        drink = MenuItem(name="Soft Drink", description="Cola, Sprite, Fanta", price=1.99, category="Drink", is_available=True)
        
        db.session.add_all([pizza, pasta, salad, burger, drink])
        
    # Create admin user if doesn't exist
    if not User.query.filter_by(username='admin').first():
        from werkzeug.security import generate_password_hash
        admin = User(
            username='admin',
            email='admin@example.com',
            password=generate_password_hash('password'),
            is_admin=True
        )
        db.session.add(admin)
    
    db.session.commit()

if __name__ == '__main__':
    app = create_app()
    app.run(debug=True)