from rest_framework import routers,serializers,viewsets
from .models import Produk

class ProdukSerializer(serializers.HyperlinkedModelSerializer):
    kategori_id = serializers.IntegerField()
    status_id = serializers.IntegerField()
    
    class Meta:
        model = Produk
        fields = ['id', 'nama', 'harga', 'kategori_id', 'status_id']
        

class JoinSerializer(serializers.HyperlinkedModelSerializer):
    nama_kategori = serializers.CharField(source='kategori.nama')
    nama_status = serializers.CharField(source='status.nama')

    class Meta:
        model = Produk
        fields = ['id', 'nama', 'harga', 'nama_kategori', 'nama_status', 'kategori_id', 'status_id']