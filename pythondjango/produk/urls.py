from django.urls import path 
from . import views

# define the urls
urlpatterns = [
    path('produk/', views.tasks),
    path('produk/<int:pk>/', views.task_detail),
]