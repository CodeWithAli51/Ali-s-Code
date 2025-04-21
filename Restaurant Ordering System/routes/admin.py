from flask import Blueprint, render_template, redirect, url_for, flash, request
from flask_login import login_required, current_user
from models import db, MenuItem, Order, OrderItem, User
from datetime import datetime

admin_bp = Blueprint('admin', __name__, url_prefix='/admin')

# Decorator to check if user is admin
def admin_required(func):
    @login_required
    def decorated_view(*args, **kwargs):
        if not current_user.is_admin:
            flash('Admin access required')
            return redirect(url_for('index'))
        return func(*args, **kwargs)
    decorated_view.__name__ = func.__name__
    return decorated_view

@admin_bp.route('/')
@admin_required
def dashboard():
    # Get counts and stats for dashboard
    total_orders = Order.query.count()
    pending_orders = Order.query.filter_by(status='pending').count()
    completed_orders = Order.query.filter(Order.status.in_(['delivered', 'ready'])).count()
    total_users = User.query.filter_by(is_admin=False).count()
    
    # Get latest orders
    latest_orders = Order.query.order_by(Order.created_at.desc()).limit(5).all()
    
    # Calculate revenue
    revenue = db.session.query(db.func.sum(Order.total_amount)).scalar() or 0
    
    return render_template('admin/dashboard.html', 
                          total_orders=total_orders,
                          pending_orders=pending_orders,
                          completed_orders=completed_orders,
                          total_users=total_users,
                          latest_orders=latest_orders,
                          revenue=revenue)

# Menu Item CRUD
@admin_bp.route('/menu_items')
@admin_required
def menu_items():
    items = MenuItem.query.all()
    return render_template('admin/menu_items.html', items=items)

@admin_bp.route('/menu_items/add', methods=['GET', 'POST'])
@admin_required
def add_menu_item():
    if request.method == 'POST':
        name = request.form.get('name')
        description = request.form.get('description')
        price = float(request.form.get('price'))
        category = request.form.get('category')
        is_available = True if request.form.get('is_available') == 'on' else False
        
        item = MenuItem(
            name=name,
            description=description,
            price=price,
            category=category,
            is_available=is_available
        )
        db.session.add(item)
        db.session.commit()
        flash('Menu item added successfully!')
        return redirect(url_for('admin.menu_items'))
        
    return render_template('admin/add_menu_item.html')

@admin_bp.route('/menu_items/edit/<int:item_id>', methods=['GET', 'POST'])
@admin_required
def edit_menu_item(item_id):
    item = MenuItem.query.get_or_404(item_id)
    
    if request.method == 'POST':
        item.name = request.form.get('name')
        item.description = request.form.get('description')
        item.price = float(request.form.get('price'))
        item.category = request.form.get('category')
        item.is_available = True if request.form.get('is_available') == 'on' else False
        
        db.session.commit()
        flash('Menu item updated successfully!')
        return redirect(url_for('admin.menu_items'))
        
    return render_template('admin/edit_menu_item.html', item=item)

@admin_bp.route('/menu_items/delete/<int:item_id>', methods=['POST'])
@admin_required
def delete_menu_item(item_id):
    item = MenuItem.query.get_or_404(item_id)
    db.session.delete(item)
    db.session.commit()
    flash('Menu item deleted successfully!')
    return redirect(url_for('admin.menu_items'))

# Order Management
@admin_bp.route('/orders')
@admin_required
def orders():
    status_filter = request.args.get('status', '')
    
    if status_filter:
        orders = Order.query.filter_by(status=status_filter).order_by(Order.created_at.desc()).all()
    else:
        orders = Order.query.order_by(Order.created_at.desc()).all()
        
    return render_template('admin/orders.html', orders=orders, current_filter=status_filter)

@admin_bp.route('/orders/<int:order_id>')
@admin_required
def view_order(order_id):
    order = Order.query.get_or_404(order_id)
    return render_template('admin/view_order.html', order=order)

@admin_bp.route('/orders/update_status/<int:order_id>', methods=['POST'])
@admin_required
def update_order_status(order_id):
    order = Order.query.get_or_404(order_id)
    new_status = request.form.get('status')
    
    if new_status in ['pending', 'preparing', 'ready', 'delivered', 'cancelled']:
        order.status = new_status
        order.updated_at = datetime.utcnow()
        db.session.commit()
        flash(f'Order #{order.id} status updated to {order.status_display}')
    
    return redirect(url_for('admin.view_order', order_id=order.id))

# User Management
@admin_bp.route('/users')
@admin_required
def users():
    users = User.query.filter_by(is_admin=False).all()
    return render_template('admin/users.html', users=users)