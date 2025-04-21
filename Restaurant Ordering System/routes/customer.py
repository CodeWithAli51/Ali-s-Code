from flask import Blueprint, render_template, redirect, url_for, flash, request, jsonify
from flask_login import login_required, current_user
from models import db, MenuItem, Order, OrderItem
from datetime import datetime

customer_bp = Blueprint('customer', __name__, url_prefix='/customer')

@customer_bp.route('/menu')
@login_required
def menu():
    menu_items = MenuItem.query.filter_by(is_available=True).all()
    categories = set(item.category for item in menu_items)
    return render_template('customer/menu.html', menu_items=menu_items, categories=categories)

@customer_bp.route('/add_to_cart/<int:item_id>', methods=['POST'])
@login_required
def add_to_cart(item_id):
    if not request.is_json:
        return jsonify({'status': 'error', 'message': 'Invalid request'}), 400
        
    data = request.get_json()
    quantity = int(data.get('quantity', 1))
    
    if quantity <= 0:
        return jsonify({'status': 'error', 'message': 'Invalid quantity'}), 400
        
    menu_item = MenuItem.query.get_or_404(item_id)
    
    if not menu_item.is_available:
        return jsonify({'status': 'error', 'message': 'Item not available'}), 400
    
    # Use session to store cart data
    cart = request.cookies.get('cart', {})
    if isinstance(cart, str):
        import json
        try:
            cart = json.loads(cart)
        except:
            cart = {}
    
    item_key = str(item_id)
    if item_key in cart:
        cart[item_key]['quantity'] += quantity
    else:
        cart[item_key] = {
            'id': menu_item.id,
            'name': menu_item.name,
            'price': menu_item.price,
            'quantity': quantity
        }
    
    response = jsonify({'status': 'success', 'message': 'Item added to cart', 'cart': cart})
    response.set_cookie('cart', json.dumps(cart))
    return response

@customer_bp.route('/cart')
@login_required
def view_cart():
    import json
    cart = request.cookies.get('cart', '{}')
    try:
        cart = json.loads(cart)
    except:
        cart = {}
    
    items = []
    total = 0
    
    for item_id, item_data in cart.items():
        subtotal = item_data['price'] * item_data['quantity']
        items.append({
            'id': item_data['id'],
            'name': item_data['name'],
            'price': item_data['price'],
            'quantity': item_data['quantity'],
            'subtotal': subtotal
        })
        total += subtotal
    
    return render_template('customer/cart.html', items=items, total=total)

@customer_bp.route('/checkout', methods=['POST'])
@login_required
def checkout():
    import json
    cart = request.cookies.get('cart', '{}')
    try:
        cart = json.loads(cart)
    except:
        cart = {}
    
    if not cart:
        flash('Your cart is empty')
        return redirect(url_for('customer.menu'))
    
    # Calculate total
    total = 0
    for item_id, item_data in cart.items():
        total += item_data['price'] * item_data['quantity']
    
    # Create order
    order = Order(
        user_id=current_user.id,
        status='pending',
        total_amount=total
    )
    db.session.add(order)
    db.session.flush()  # Get the order ID
    
    # Add order items
    for item_id, item_data in cart.items():
        order_item = OrderItem(
            order_id=order.id,
            menu_item_id=item_data['id'],
            quantity=item_data['quantity'],
            price=item_data['price']
        )
        db.session.add(order_item)
    
    db.session.commit()
    
    # Clear cart
    response = redirect(url_for('customer.order_confirmation', order_id=order.id))
    response.set_cookie('cart', '', expires=0)
    return response

@customer_bp.route('/order_confirmation/<int:order_id>')
@login_required
def order_confirmation(order_id):
    order = Order.query.get_or_404(order_id)
    
    # Make sure the order belongs to the current user
    if order.user_id != current_user.id:
        flash('Unauthorized access')
        return redirect(url_for('customer.menu'))
    
    return render_template('customer/order_confirmation.html', order=order)

@customer_bp.route('/my_orders')
@login_required
def my_orders():
    orders = Order.query.filter_by(user_id=current_user.id).order_by(Order.created_at.desc()).all()
    return render_template('customer/my_orders.html', orders=orders)